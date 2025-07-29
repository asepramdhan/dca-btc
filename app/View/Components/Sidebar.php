<?php

namespace App\View\Components;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Sidebar extends Component
{
    // User yang sedang login
    public User|null $user;

    // Status premium user
    // true jika masih premium, false jika tidak
    public bool $isStillPremium;

    // Status free trial user
    // true jika masih free trial, false jika tidak
    public bool $isFreeTrial;

    // Status free user
    // true jika user free, false jika tidak
    public bool $isFree;

    // Status premium user dalam bentuk string
    // Contoh: "Expired 3 hari lalu", "7 hari lagi", "Hari terakhir"
    public string $premiumStatus;

    public function __construct()
    {
        // Ambil user yang sedang login
        $this->user = Auth::user();

        // Ambil waktu sekarang
        $now = now();

        // Ambil tanggal akhir premium user
        $premiumUntil = $this->user?->premium_until
            ? Carbon::parse($this->user->premium_until)
            : null;

        // Cek apakah user masih premium
        $this->isStillPremium = $premiumUntil && $premiumUntil->gt($now);

        // Cek apakah user masih free trial
        $this->isFreeTrial = !$premiumUntil && $this->user?->created_at?->gte($now->subDays(7));

        // Cek apakah user free
        $this->isFree = !$this->isStillPremium && !$this->isFreeTrial;

        // Ambil status premium user dalam bentuk string
        $this->premiumStatus = $this->getPremiumStatus($this->user);
    }

    // Fungsi untuk mengambil status premium user dalam bentuk string
    public function getPremiumStatus(?User $user): string
    {
        // Jika user tidak ada, maka return '-'
        if (!$user) return '-';

        // Jika user tidak memiliki tanggal akhir premium, maka cek apakah user free trial
        if (!$user->premium_until) {
            // Cek apakah user masih free trial
            $diff = Carbon::now()->diff($user->created_at->addDays(7));
            $days = $diff->days;

            return $diff->invert
                ? "expired {$days} hari lalu"
                : ($days > 0
                    ? "{$days} hari lagi"
                    : 'Hari terakhir');
        }

        // Jika user memiliki tanggal akhir premium, maka cek apakah user masih premium
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

    // Fungsi untuk merender view sidebar
    public function render(): View|Closure|string
    {
        // Merender view sidebar dengan data user, status premium, status free trial, dan status free
        return view('components.sidebar', [
            'user' => $this->user,
            'isStillPremium' => $this->isStillPremium,
            'isFreeTrial' => $this->isFreeTrial,
            'isFree' => $this->isFree,
            'premiumStatus' => $this->premiumStatus,
        ]);
    }
}
