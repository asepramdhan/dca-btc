<?php

namespace App\Livewire;

use App\Models\User;
use App\Traits\MiniToast;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    use MiniToast;
    public $name, $username, $email, $password;
    public function register(): void
    {
        $dataValid = $this->validate([
            'name' => 'required|min:3',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ], messages: [
            'name.required' => 'Nama lengkap harus diisi',
            'name.min' => 'Nama lengkap minimal 3 karakter',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah terdaftar',
            'email.required' => 'E-mail harus diisi',
            'email.email' => 'E-mail tidak valid',
            'email.unique' => 'E-mail sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);
        $dataValid['password'] = Hash::make($dataValid['password']);
        User::create($dataValid);
        $this->miniToast('Register Berhasil', redirectTo: route('login'));
    }
    public function render()
    {
        return view('livewire.register');
    }
}
