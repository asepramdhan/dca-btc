<?php

namespace App\Livewire;

use App\Models\Transaction;
use App\Traits\MiniToast;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail; // <-- Tambahkan ini
use App\Mail\AdminPaymentNotificationMail; // <-- Tambahkan ini
use Illuminate\Support\Facades\Config; // <-- Tambahkan ini untuk mengakses config

class Transactions extends Component
{
    use MiniToast, WithPagination;

    public $user;
    public $search = '';
    public bool $paymentModal = false;
    public bool $selectPaymentModal = false;
    public int|null $pendingUpdatePayment = null;
    public $currentOrderId = null; // Properti baru untuk menyimpan order_id yang sedang diproses
    public $payment, $QRCode;
    public $expiryTimestamp; // Mengubah dari timeExpired string ke timestamp Carbon
    public $descriptionText; // <-- Properti baru untuk deskripsi dinamis
    public $howPayment = 'Silahkan buka aplikasi (Gopay, ShopeePay, OVO atau Mobile Banking), kemudian scan QR Code untuk melakukan pembayaran.';

    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'created_at', 'label' => 'Tanggal & Waktu'],
        ['key' => 'package.name', 'label' => 'Nama Paket'],
        ['key' => 'order_id', 'label' => 'ID Pesanan'],
        ['key' => 'payment_type', 'label' => 'Tipe Pembayaran'],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'amount', 'label' => 'Jumlah'],
    ];

    public function mount(): void
    {
        $this->user = Auth::user();
        // Panggil method untuk memeriksa status setiap kali komponen dimuat
        $this->checkExpiredTransactions();
    }
    /**
     * 💡 Method baru untuk memeriksa dan update transaksi yang kedaluwarsa.
     */
    public function checkExpiredTransactions(): void
    {
        $userId = Auth::id();
        $now = Carbon::now();
        // --- Logika untuk QRIS (Expired dalam 15 Menit) ---
        $qrisExpiryTime = $now->copy()->subMinutes(15);
        Transaction::where('user_id', $userId)
            ->where('status', 'pending')
            ->where('payment_type', 'qris') // Hanya untuk transaksi QRIS
            ->where('created_at', '<', $qrisExpiryTime)
            ->update(['status' => 'expire']);
        // --- Logika untuk Pembayaran Lainnya (Expired dalam 24 Jam) ---
        $otherPaymentExpiryTime = $now->copy()->subHours(24);
        Transaction::where('user_id', $userId)
            ->where('status', 'pending')
            ->where(function ($query) {
                $query->where('payment_type', '!=', 'qris') // Untuk pembayaran selain QRIS
                    ->orWhereNull('payment_type');       // atau yang belum memilih metode pembayaran
            })
            ->where('created_at', '<', $otherPaymentExpiryTime)
            ->update(['status' => 'expire']);
    }
    public function lanjutBayar($id): void
    {
        $transaction = Transaction::findOrFail($id);
        $this->expiryTimestamp = $transaction->expiry_timestamp;
        // 1. Validasi jika transaksi sudah expired ngambil dari expiryTimestamp
        if ($this->expiryTimestamp < Carbon::now()->timestamp) {
            $this->selectPaymentModal = false;
            $this->miniToast('Transaksi sudah kedaluwarsa.', 'error', redirectTo: '/auth/transactions');
            return;
        }
        if ($transaction->package_id == 1 && $transaction->payment_type == 'qris') {
            $this->selectPaymentModal = true;
            $this->currentOrderId = $transaction->order_id;
            $this->expiryTimestamp = $transaction->expiry_timestamp;
            $this->QRCode = 'images/upgrade/normal/1bln.jpg';
        } elseif ($transaction->package_id == 2 && $transaction->payment_type == 'qris') {
            $this->selectPaymentModal = true;
            $this->currentOrderId = $transaction->order_id;
            $this->expiryTimestamp = $transaction->expiry_timestamp;
            $this->QRCode = 'images/upgrade/normal/2bln.jpg';
        } elseif ($transaction->package_id == 3 && $transaction->payment_type == 'qris') {
            $this->selectPaymentModal = true;
            $this->currentOrderId = $transaction->order_id;
            $this->expiryTimestamp = $transaction->expiry_timestamp;
            $this->QRCode = 'images/upgrade/normal/1thn.jpg';
        } else {
            $this->selectPaymentModal = true;
            $this->currentOrderId = $transaction->order_id;
            $this->QRCode = 'images/upgrade/bank_transfer_instructions.jpg'; // Contoh gambar instruksi
            // Set deskripsi untuk Transfer Bank
            $this->descriptionText = 'Selesaikan pembayaran melalui transfer bank.';
            $this->howPayment = 'Silahkan melakukan transfer sebesar Rp ' . number_format($transaction->amount, 0, ',', '.') . ' ke rekening yang dipilih diatas';
        }
    }
    public function confirmPayment(): void
    {
        $this->selectPaymentModal = false;
        $this->updateDataPremium();

        // Ambil data transaksi yang baru saja di-update atau dibuat
        $transaction = Transaction::where('order_id', $this->currentOrderId)->first();
        // Kirim email notifikasi ke administrator jika transaksi ditemukan
        if ($transaction) {
            try {
                // Mengambil alamat email admin dari .env
                $adminEmail = Config::get('app.admin_email', env('ADMIN_EMAIL')); // Menggunakan Config::get untuk lebih aman

                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new AdminPaymentNotificationMail($transaction));
                } else {
                    $this->miniToast('Mohon ditunggu admin sedang tidak online', 'error', timeout: 3000, redirectTo: '/auth/transactions');
                }
            } catch (\Exception $e) {
                $this->miniToast('Maaf sedang terjadi gangguan, silahkan hubungi admin melalui chat', 'error', timeout: 3000, redirectTo: '/auth/transactions');
            }
        }

        // Tampilkan pesan ke pengguna
        $this->miniToast('Terimakasih telah melakukan pembayaran, Kami akan segera proses', timeout: 3000, redirectTo: '/auth/transactions');
    }
    public function cancelPayment(): void
    {
        $this->paymentModal = false;
        $this->selectPaymentModal = false;
    }
    private function updateDataPremium(): void
    {
        $transactionId = uniqid('TRX-');
        $data = Transaction::where('order_id', $this->currentOrderId)->first(); // Cari transaksi yang sudah ada
        $data->update([ // Update statusnya
            'transaction_id' => $transactionId,
            'status' => 'process',
        ]);
    }
    public function render()
    {
        return view('livewire.transactions', [
            'transactions' => Transaction::where('user_id', Auth::id())->whereNotNull('payment_type')->where(function ($query) {
                $query->where('user_id', Auth::user()->id);
                if ($this->search) {
                    $query->whereDate('created_at', 'like', '%' . $this->search . '%')
                        ->orWhereRaw("DATE_FORMAT(created_at, '%d-%m-%Y %H:%i') LIKE '%" . $this->search . "%'")
                        ->orWhere('payment_type', 'like', '%' . $this->search . '%');
                }
            })->latest()->paginate(10),
        ]);
    }
}
