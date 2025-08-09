<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\Transaction; // <-- Pastikan ini sudah di-use
use App\Traits\MiniToast;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Upgrade extends Component
{
    use MiniToast;
    public $user, $packages, $paketUser, $paket1, $paket2, $paket3, $voucher;
    public string $snapToken;
    public bool $voucherModal = false;
    public int|null $pendingUpdateVoucher = null;
    public bool $paymentModal = false;
    public bool $selectPaymentModal = false;
    public int|null $pendingUpdatePayment = null;
    public $currentOrderId = null; // Properti baru untuk menyimpan order_id yang sedang diproses
    public $payment, $QRCode;
    public $expiryTimestamp; // Mengubah dari timeExpired string ke timestamp Carbon
    public $descriptionText; // <-- Properti baru untuk deskripsi dinamis
    public $howPayment = 'Silahkan buka aplikasi (Gopay, ShopeePay, OVO atau Mobile Banking), kemudian scan QR Code untuk melakukan pembayaran.';

    public function mount(): void
    {
        $this->packages = Package::all();
        foreach ($this->packages as $paket) {
            if ($paket->duration == 30) {
                $this->paket1 = $paket;
            }
            if ($paket->duration == 60) {
                $this->paket2 = $paket;
            }
            if ($paket->duration == 365) {
                $this->paket3 = $paket;
            }
        }
        $this->user = Auth::user();
    }

    public function pay($id): void
    {
        $this->paketUser = $this->packages->where('id', $id)->first();
        $this->pendingUpdatePayment = $this->user->id;
        $this->paymentModal = true;
    }
    public function updatedPayment($value)
    {
        $this->paymentModal = false;
        $this->selectPaymentModal = true;

        if ($value == 'qris') {
            if ($this->paketUser->duration == 30) {
                $this->QRCode = 'images/upgrade/normal/1bln.jpg';
            } else if ($this->paketUser->duration == 60) {
                $this->QRCode = 'images/upgrade/normal/2bln.jpg';
            } else if ($this->paketUser->duration == 365) {
                $this->QRCode = 'images/upgrade/normal/1thn.jpg';
            }
            // Set waktu expired untuk QRIS (15 menit) sebagai timestamp UNIX
            $this->expiryTimestamp = Carbon::now()->addMinutes(15)->timestamp;
            // Atau sebagai string ISO 8601 jika lebih nyaman di JS:
            // $this->expiryTimestamp = Carbon::now()->addMinutes(15)->toISOString();
            // Set deskripsi untuk QRIS
            $this->descriptionText = 'Scan QR Code untuk melakukan pembayaran!';
            $this->handlePayment();
        } else { // Jika metode pembayaran adalah transfer bank
            // Set waktu expired untuk Transfer Bank (24 jam)
            $this->expiryTimestamp = Carbon::now()->addHours(24)->timestamp;
            $this->QRCode = 'images/upgrade/bank_transfer_instructions.jpg'; // Contoh gambar instruksi
            // Set deskripsi untuk Transfer Bank
            $this->descriptionText = 'Selesaikan pembayaran melalui transfer bank.';
            $this->howPayment = 'Silahkan melakukan transfer sebesar Rp ' . number_format($this->paketUser->price, 0, ',', '.') . ' ke rekening yang dipilih diatas';
            $this->handlePayment();
        }
    }
    public function confirmPayment(): void
    {
        $this->selectPaymentModal = false;
        $this->updateDataPremium();
        $this->miniToast('Terimakasih telah melakukan pembayaran, silahkan tunggu beberapa saat untuk diaktifkan', timeout: 3000, redirectTo: '/auth/transactions');
    }
    public function cancelPayment(): void
    {
        $this->paymentModal = false;
        $this->selectPaymentModal = false;
        $this->miniToast('Silahkan lanjutkan pembayaran di menu transaksi', timeout: 3000, redirectTo: '/auth/transactions');
    }
    private function handlePayment(): void
    {
        $orderId = uniqid('INV-');
        // Simpan orderId ke properti class agar bisa diakses di confirmPayment()
        $this->currentOrderId = $orderId;
        Transaction::create([
            'user_id' => $this->user->id,
            'package_id' => $this->paketUser->id,
            'package_name' => $this->paketUser->name,
            'order_id' => $orderId,
            'payment_type' => $this->payment,
            'amount' => $this->paketUser->price,
            'expiry_timestamp' => $this->expiryTimestamp, // Simpan expiryTimestamp saat transaksi dibuat
        ]);
    }
    private function updateDataPremium(): void
    {
        $transactionId = uniqid('TRX-');
        $data = Transaction::where('order_id', $this->currentOrderId)->first(); // Cari transaksi yang sudah ada
        $data->update([ // Update statusnya
            'transaction_id' => $transactionId,
            'status' => 'process',
        ]);
        // $this->user->update([
        //     'account_type' => 'premium',
        //     'premium_until' => Carbon::now()->addDays($this->paketUser->duration),
        // ]);
    }
    public function masukanVoucher(): void
    {
        $this->pendingUpdateVoucher = $this->user->id;
        $this->voucherModal = true;
    }
    public function confirmVoucher(): void
    {
        $this->validasiData();
        $this->voucherModal = false;
        $this->miniToast('Akun berhasil diupgrade, Terimakasih', timeout: 3000, redirectTo: '/auth/dashboard');
    }
    private function validasiData(): void
    {
        $this->validate([
            'voucher' => 'required|min:5',
        ], messages: [
            'voucher.required' => 'Voucher tidak boleh kosong.',
            'voucher.min' => 'Voucher minimal 5 karakter.',
        ]);
        $dataVoucher = $this->user->load(['vouchers' => function ($query) {
            $query->where('is_active', true)->where('usage_limit', '>', 'used_count')->where('code', $this->voucher);
        }]);

        if ($dataVoucher->vouchers->first()) {
            $this->pendingUpdateVoucher = $dataVoucher->vouchers->first()->id;
            $this->updateData();
        } else {
            $this->validate([
                'voucher' => 'boolean',
            ], messages: [
                'voucher.boolean' => 'Voucher tidak valid.',
            ]);
        }
    }
    private function updateData(): void
    {
        $dataVoucher = $this->user->vouchers()->find($this->pendingUpdateVoucher)->load('package');
        $dataVoucher->update([
            'used_count' => $dataVoucher->used_count + 1,
            'is_active' => false
        ]);
        $this->user->transactions()->create([
            'package_id' => $dataVoucher->package_id,
            'order_id' => uniqid('INV-'),
            'voucher_id' => $dataVoucher->id,
            'payment_type' => 'voucher',
            'package_name' => $dataVoucher->package->name,
            'amount' => $dataVoucher->package->price,
            'status' => 'settlement'
        ]);
        $this->user->update([
            'account_type' => 'premium',
            'premium_until' => Carbon::now()->addDays((int) $dataVoucher->package->duration)
        ]);
    }
    public function render()
    {
        return view('livewire.upgrade', [
            'satuBulan' => $this->paket1,
            'duaBulan' => $this->paket2,
            'satuTahun' => $this->paket3
        ]);
    }
}
