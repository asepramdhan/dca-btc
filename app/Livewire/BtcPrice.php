<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class BtcPrice extends Component
{
    public ?int $bitcoinIdr = null;

    public function mount()
    {
        $this->loadBitcoinPrice();
    }
    public function updateBitcoinPrice(): void
    {
        $this->loadBitcoinPrice();
    }
    private function loadBitcoinPrice(): void
    {
        $this->bitcoinIdr = Cache::remember('btc-idr-price', 300, function () {
            $response = Http::get('https://api.coingecko.com/api/v3/simple/price', [
                'ids' => 'bitcoin',
                'vs_currencies' => 'idr',
            ]);

            if ($response->successful()) {
                return (int) ($response->json('bitcoin.idr') ?? 0);
            }

            return 0;
        });
    }
    public function render()
    {
        return view('livewire.btc-price');
    }
}
