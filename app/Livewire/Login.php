<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Mary\Traits\Toast;

class Login extends Component
{
    use Toast;
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

        if ($user && Hash::check($dataValid['password'], $user->password)) {
            Auth::login($user);
            $this->success('Login Berhasil', redirectTo: route('dashboard'));
        } else {
            $this->error('Username, E-mail atau Password Salah');
        }
    }
    public function render()
    {
        return view('livewire.login');
    }
}
