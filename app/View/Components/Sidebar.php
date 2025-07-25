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
    /**
     * Create a new component instance.
     */
    public function getPremiumStatus(User $user): string
    {
        if (!$user->premium_until) {
            return '-';
        }

        $diff = Carbon::now()->diff(Carbon::parse($user->premium_until));

        $days = $diff->days;
        return $diff->invert
            ? "Expired {$days} hari lalu"
            : ($days > 0
                ? "{$days} hari lagi"
                : ($days === 0
                    ? 'Hari terakhir'
                    : 'Expired'));
    }
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}
