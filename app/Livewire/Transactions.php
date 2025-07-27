<?php

namespace App\Livewire;

use App\Models\Transaction;
use App\Traits\MiniToast;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction as MidtransTransaction;

class Transactions extends Component
{
    use MiniToast;
    public $user;
    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'created_at', 'label' => 'Tanggal & Waktu'],
        ['key' => 'package.name', 'label' => 'Nama Paket'], // asumsi relasi package
        ['key' => 'order_id', 'label' => 'ID Pesanan'],
        ['key' => 'payment_type', 'label' => 'Tipe Pembayaran'],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'amount', 'label' => 'Jumlah'],
    ];
    public function mount(): void
    {
        $this->user = Auth::user();
    }
    public function pay($id): void
    {
        // ✅ Tambahkan ini di atas sebelum Snap/status dipanggil
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $transaction = Transaction::findOrFail($id);
        dd($transaction);

        // ✅ Tambahan: cek status terbaru dari Midtrans
        if ($transaction->snap_token) {
            try {
                $status = MidtransTransaction::status($transaction->order_id);
                $transactionStatus = $status['transaction_status'];

                if (in_array($transactionStatus, ['settlement', 'capture'])) {
                    $transaction->update(['status' => 'success']);

                    // ✅ Upgrade akun user ke premium
                    $user = $transaction->user;
                    $user->update([
                        'account_type' => 'premium',
                        'premium_until' => Carbon::now()->addDays($user->package->duration),
                    ]);

                    // ✅ Jangan lanjut ke popup, langsung redirect ke dashboard
                    $this->miniToast('Transaksi berhasil. Akun Anda sudah premium.', timeout: 3000, redirectTo: '/auth/dashboard');
                    return; // ⬅️ INI PENTING AGAR SKIP BAGIAN SNAP POPUP
                }

                if (in_array($transactionStatus, ['expire', 'cancel'])) {
                    $transaction->update(['status' => 'expired']);
                    $this->miniToast('Transaksi dibatalkan.');
                    return;
                }

                // Jika masih pending, lanjut ke Snap popup
            } catch (\Exception $e) {
                $this->dispatch('console-log', [
                    'message' => 'Midtrans Error: ' . $e->getMessage(),
                ]);
                logger()->error('Gagal cek status Midtrans: ' . $e->getMessage());
                // ❗ Tambahkan return agar tidak lanjut ke bawah
                $this->miniToast('Gagal cek status transaksi. Coba lagi nanti.', 'error', timeout: 3000);
                return;
            }
        }

        // 🟡 Token belum ada, buat dulu
        if (!$transaction->snap_token) {
            $params = [
                'transaction_details' => [
                    'order_id' => $transaction->order_id,
                    'gross_amount' => $transaction->amount,
                ],
                'customer_details' => [
                    'first_name' => $transaction->user->name,
                    'email' => $transaction->user->email,
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            $transaction->update([
                'snap_token' => $snapToken,
            ]);
        } else {
            $snapToken = $transaction->snap_token;
        }

        // ⏩ Kirim ke browser untuk tampilkan popup Snap
        $this->dispatch('snap-token-received', token: $snapToken);
    }
    public function checkStatuses(): void
    {
        // ✅ Tambahan: cek status terbaru dari Midtrans

        $pending = Transaction::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->whereNotNull('snap_token')
            ->get();

        foreach ($pending as $trx) {
            try {
                // Ambil status terbaru dari Midtrans
                $status = MidtransTransaction::status($trx->order_id);

                $midtransStatus = $status['transaction_status'];
                $mappedStatus = match ($midtransStatus) {
                    'settlement', 'capture' => 'success',
                    'deny', 'cancel', 'expire' => 'expired',
                    default => 'pending',
                };

                // Update status jika berubah
                if ($trx->status !== $mappedStatus) {
                    $trx->update([
                        'status' => $mappedStatus,
                        'payment_type' => $status['payment_type'] ?? $trx->payment_type,
                        'transaction_id' => $status['transaction_id'] ?? $trx->transaction_id,
                        'raw_response' => json_encode($status),
                    ]);
                }
            } catch (\Exception $e) {
                // Fallback: jika tidak bisa akses Midtrans, dan sudah >10 menit → expired
                if ($trx->created_at->diffInMinutes(now()) >= 10) {
                    $trx->update(['status' => 'expired']);
                }

                logger()->error('Midtrans status check failed: ' . $e->getMessage());
            }
        }
    }
    public function handlePayment($result): void
    {
        $trx = Transaction::where('order_id', $result['order_id'])->first();

        $trx->update([
            'transaction_id' => $result['transaction_id'],
            'payment_type' => $result['payment_type'],
            'status' => $result['transaction_status'],
        ]);

        if ($trx->status === 'settlement' || $trx->status === 'capture') {
            $this->user->update([
                'account_type' => 'premium',
                'premium_until' => Carbon::now()->addDays($trx->package->duration),
            ]);

            $this->miniToast('Pembayaran berhasil.', redirectTo: '/auth/dashboard');
        } else {
            $this->miniToast('Lanjutkan pembayaran di menu transaksi', 'info', timeout: 3000, redirectTo: '/auth/transactions');
        }
    }
    public function render()
    {
        return view('livewire.transactions', [
            'transactions' => Transaction::where('user_id', Auth::user()->id)->where('payment_type', '!=', null)->latest()->paginate(10),
        ]);
    }
}
