<?php

namespace App\Livewire;

use App\Models\User;
use App\Traits\MiniToast;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class TambahUser extends Component
{
    use MiniToast;
    public $name, $username, $email, $password;
    public function tambahLagi(): void
    {
        $this->validasiData();
        $this->tambahData();
        $this->reset('name', 'username', 'email', 'password');
        $this->miniToast('User berhasil ditambahkan, silahkan tambah lagi', timeout: 3000);
    }
    public function tambahDanKembali(): void
    {
        $this->validasiData();
        $this->tambahData();
        $this->miniToast('User berhasil ditambahkan', redirectTo: route('admin.user'));
    }
    private function validasiData(): void
    {
        $this->validate([
            'name' => 'required|string|min:3',
            'username' => 'required|string|min:3|unique:users|regex:/^\S*$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ], messages: [
            'name.required' => 'Nama harus diisi.',
            'name.string' => 'Nama harus berupa string.',
            'name.min' => 'Nama minimal 3 karakter.',
            'username.required' => 'Username harus diisi.',
            'username.string' => 'Username harus berupa string.',
            'username.min' => 'Username minimal 3 karakter.',
            'username.unique' => 'Username sudah terdaftar.',
            'username.regex' => 'Username tidak boleh mengandung spasi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);
    }
    private function tambahData(): void
    {
        User::create([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
    }
    public function render()
    {
        return view('livewire.tambah-user');
    }
}
