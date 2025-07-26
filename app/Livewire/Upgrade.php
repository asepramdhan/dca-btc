<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Midtrans\Config;
use Midtrans\Snap;

class Upgrade extends Component
{
    public $user;

    public function mount(): void
    {
        $this->user = Auth::user();
        // Set konfigurasi Midtrans
        // Config::$serverKey = config('midtrans.server_key');
        // Config::$clientKey = config('midtrans.client_key');
        // Config::$isProduction = config('midtrans.is_production');
        // Config::$isSanitized = true;
        // Config::$is3ds = true;
    }

    public function pay(): void
    {
        // Set konfigurasi Midtrans DI SINI
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
        $params = [
            'transaction_details' => [
                'order_id' => uniqid('INV-'),
                'gross_amount' => 30000,
            ],
            'customer_details' => [
                'first_name' => $this->user->name,
                'email' => $this->user->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $this->dispatch('snap-token-received', token: $snapToken);
    }

    public function render()
    {
        return view('livewire.upgrade');
    }
}
