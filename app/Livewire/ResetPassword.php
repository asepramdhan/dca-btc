<?php

namespace App\Livewire;

use App\Models\User;
use App\Traits\MiniToast;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ResetPassword extends Component
{
    use MiniToast;
    public $token;
    public $email;
    public $password;
    public $password_confirmation;

    public function mount($token): void
    {
        $this->token = $token;
    }
    public function resetPassword(): void
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], messages: [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Password tidak cocok.',
        ]);

        $status = Password::reset([
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'token' => $this->token,
        ], function (User $user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();
        });

        if ($status === Password::PASSWORD_RESET) {
            $this->miniToast('Password berhasil diubah. Silakan login kembali.', timeout: 3000, redirectTo: '/guest/login');
        } else {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }
    }
    public function render()
    {
        return view('livewire.reset-password');
    }
}
