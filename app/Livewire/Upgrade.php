<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\Transaction;
use App\Traits\MiniToast;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Midtrans\Config;
use Midtrans\Snap;

class Upgrade extends Component
{
    use MiniToast;
    public $user, $packages, $paketUser, $paket1, $paket2, $paket3;
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
        // Set konfigurasi Midtrans DI SINI
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
        $params = [
            'transaction_details' => [
                'order_id' => uniqid('INV-'),
                'gross_amount' => $this->paketUser->price,
            ],
            'customer_details' => [
                'first_name' => $this->user->name,
                'email' => $this->user->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // Simpan transaksi pending dulu
        Transaction::create([
            'user_id' => $this->user->id,
            'package_id' => $this->paketUser->id,
            'order_id' => $params['transaction_details']['order_id'],
            'status' => 'pending',
            'amount' => $this->paketUser->price,
            'snap_token' => $snapToken,
        ]);

        $this->dispatch('snap-token-received', token: $snapToken);
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
                'premium_until' => Carbon::now()->addDays((int) $trx->package->duration),
            ]);

            $this->miniToast('Pembayaran berhasil.', redirectTo: '/auth/dashboard');
        } else {
            $this->miniToast('Lanjutkan pembayaran di menu transaksi', 'info', timeout: 3000, redirectTo: '/auth/transactions');
        }
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
