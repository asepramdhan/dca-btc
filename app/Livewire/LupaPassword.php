<?php

namespace App\Livewire;

use App\Traits\MiniToast;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class LupaPassword extends Component
{
    use MiniToast;
    public $email;
    public function lupaPassword(): void
    {
        $this->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->miniToast('Link reset password telah dikirim ke email Anda.', timeout: 3000, redirectTo: '/guest/login');
        } else {
            $this->miniToast('Gagal mengirim email reset password.', 'error', timeout: 3000);
        }
    }
    public function render()
    {
        return view('livewire.lupa-password');
    }
}
