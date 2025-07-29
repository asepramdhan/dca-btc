<?php

namespace App\Livewire;

use App\Models\Transaction;
use App\Traits\MiniToast;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Midtrans\Config;
use Midtrans\Snap;
// Tidak perlu `use Midtrans\Transaction as MidtransTransaction;` jika hanya pakai Snap

class Transactions extends Component
{
    use MiniToast;

    public $user;
    // Durasi kedaluwarsa dalam jam (sesuai aturan Midtrans, default 24 jam)
    // public int $expiryDurationInHours = 1;
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
        $snapToken = $transaction->snap_token;

        // 1. Validasi status transaksi
        if ($transaction->status !== 'pending') {
            $this->miniToast('Transaksi ini sudah tidak bisa dilanjutkan.', 'warning');
            return;
        }

        // 2. Jika token belum ada, buat baru
        if (!$snapToken) {
            // Konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            try {
                $params = [
                    'transaction_details' => [
                        'order_id' => $transaction->order_id,
                        'gross_amount' => $transaction->amount,
                    ],
                    'customer_details' => [
                        'first_name' => $this->user->name,
                        'email' => $this->user->email,
                    ],
                    // --- TAMBAHKAN BAGIAN INI ---
                    'callbacks' => [
                        // 'finish' => url('/transaksi/finish/' . $transaction->order_id), // Opsional, untuk redirect browser setelah sukses
                        // 'error' => url('/transaksi/error/' . $transaction->order_id),   // Opsional, untuk redirect browser setelah error
                        // 'pending' => url('/transaksi/pending/' . $transaction->order_id), // Opsional, untuk redirect browser setelah pending
                        // 'notification' => url('/api/midtrans-webhook'), // <<--- INI YANG PALING PENTING UNTUK SERVER-TO-SERVER
                    ],
                ];

                $snapToken = Snap::getSnapToken($params);

                // Simpan token ke database agar tidak buat ulang
                $transaction->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                $this->miniToast("Gagal membuat token pembayaran: {$e->getMessage()}", 'error');
                return;
            }
        }

        // 3. Kirim token ke frontend untuk membuka popup pembayaran
        $this->dispatch('snap-token-received', token: $snapToken);
    }

    // ✅ Aktifkan kembali method ini untuk menangani callback dari Midtrans
    public function handlePayment(array $result): void
    {
        $trx = Transaction::where('order_id', $result['order_id'])->first();

        if (!$trx) {
            $this->miniToast('Transaksi tidak ditemukan.', 'error');
            return;
        }

        $trx->update([
            'transaction_id' => $result['transaction_id'],
            'payment_type' => $result['payment_type'],
            'status' => $result['transaction_status'],
        ]);

        if ($trx->status === 'settlement' || $trx->status === 'capture') {
            // Contoh: Logika setelah pembayaran sukses (misal: update status premium user)
            $this->user->update([
                'account_type' => 'premium',
                'premium_until' => Carbon::now()->addDays($trx->package->duration),
            ]);

            $this->miniToast('Pembayaran berhasil!', 'success');
            $this->dispatch('refresh-page'); // Opsional: kirim event untuk refresh halaman jika perlu
        } else {
            $this->miniToast('Lanjutkan pembayaran Anda.', 'info', timeout: 4000);
        }
    }

    public function render()
    {
        return view('livewire.transactions', [
            'transactions' => Transaction::where('user_id', Auth::id())
                ->whereNotNull('payment_type') // Asumsi Anda hanya mau menampilkan yg sudah ada interaksi midtrans
                ->latest()
                ->paginate(10),
        ]);
    }
}
