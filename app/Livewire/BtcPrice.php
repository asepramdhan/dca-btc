<?php

namespace App\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class BtcPrice extends Component
{
    public ?User $user;
    public ?int $bitcoinIdr = null;

    public bool $isStillPremium = false;
    public bool $isFreeTrial = false;
    public bool $isFree = false;
    public string $premiumStatus = '';

    public function mount()
    {
        $this->user = Auth::user();
        $this->setUserStatus();
        $this->loadBitcoinPrice();
    }

    private function setUserStatus(): void
    {
        $now = now();

        $premiumUntil = $this->user?->premium_until
            ? Carbon::parse($this->user->premium_until)
            : null;

        $this->isStillPremium = $premiumUntil && $premiumUntil->gt($now);
        $this->isFreeTrial = !$premiumUntil && $this->user?->created_at?->gte($now->subDays(7));
        $this->isFree = !$this->isStillPremium && !$this->isFreeTrial;

        $this->premiumStatus = $this->getPremiumStatus($this->user);
    }

    public function getPremiumStatus(?User $user): string
    {
        if (!$user) return '-';

        if (!$user->premium_until) {
            $diff = Carbon::now()->diff($user->created_at->addDays(7));
            $days = $diff->days;

            return $diff->invert
                ? "Free Trial expired {$days} hari lalu"
                : ($days > 0
                    ? "Free Trial sisa {$days} hari"
                    : 'Hari terakhir Free Trial');
        }

        $until = $user->premium_until instanceof Carbon
            ? $user->premium_until
            : Carbon::parse($user->premium_until);

        $diff = Carbon::now()->diff($until);
        $days = $diff->days;

        return $diff->invert
            ? "Expired {$days} hari lalu"
            : ($days > 0
                ? "{$days} hari lagi"
                : 'Hari terakhir');
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
