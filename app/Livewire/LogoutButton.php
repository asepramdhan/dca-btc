<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LogoutButton extends Component
{
    public $mode = 'icon'; // default: tampilkan tombol kecil (untuk sidebar)
    public function logout(): void
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        $this->redirect('/guest/login');
    }
    public function render()
    {
        return view('livewire.logout-button');
    }
}
