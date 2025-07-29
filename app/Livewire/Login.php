<?php

namespace App\Livewire;

use App\Models\User;
use App\Traits\MiniToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Login extends Component
{
    use MiniToast;
    public $username, $password;
    public function login(): void
    {
        $dataValid = $this->validate([
            'username' => 'required',
            'password' => 'required'
        ], messages: [
            'username.required' => 'Username atau E-mail harus diisi',
            'password.required' => 'Password harus diisi'
        ]);

        // Cari user berdasarkan username atau email
        $user = User::where('username', $dataValid['username'])
            ->orWhere('email', $dataValid['username'])
            ->first();
        if ($user) {
            // Verifikasi password
            if ($user && Hash::check($dataValid['password'], $user->password)) {
                Auth::login($user);
                $this->miniToast('Login Berhasil', redirectTo: '/auth/dashboard');
            } else {
                $this->miniToast('Username, E-mail atau Password Salah', 'error', timeout: 3000);
            }
        } else {
            $this->miniToast('Akun Tidak Ditemukan', 'error');
        }
    }
    public function render()
    {
        return view('livewire.login');
    }
}
