<?php

namespace App\Livewire;

use App\Models\User;
use App\Traits\MiniToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class AuthResetPassword extends Component
{
    use MiniToast;
    public $email;
    public $password;
    public $password_confirmation;
    public function updatePassword(): void
    {
        $this->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ], messages: [
            'password.required' => 'Password baru harus diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Password tidak cocok.',
        ]);

        User::where('id', Auth::user()->id)->update([
            'password' => Hash::make($this->password)
        ]);

        $this->miniToast('Password berhasil diubah', timeout: 3000);
        $this->reset('password', 'password_confirmation');
    }
    public function render()
    {
        return view('livewire.auth-reset-password');
    }
}
