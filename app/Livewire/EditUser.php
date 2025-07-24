<?php

namespace App\Livewire;

use App\Traits\MiniToast;
use Livewire\Component;

class EditUser extends Component
{
    use MiniToast;
    public $user, $name, $username, $email;
    public bool $is_admin = false; // Status admin (boolean)
    public function mount(): void
    {
        $this->name = $this->user->name;
        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->is_admin = (bool) $this->user->is_admin;
    }
    public function updateUser(): void
    {
        $this->validasiUser();
        $this->updateData();
        $this->miniToast('User berhasil diubah', redirectTo: route('admin.user'));
    }
    private function validasiUser(): void
    {
        $this->validate([
            'name' => 'required|string|min:3',
            'username' => 'required|string|min:3|unique:users,username,' . $this->user->id,
            'email' => 'required|email|unique:users,email,' . $this->user->id,
        ], messages: [
            'name.required' => 'Nama harus diisi.',
            'name.string' => 'Nama harus berupa string.',
            'name.min' => 'Nama minimal 3 karakter.',
            'username.required' => 'Username harus diisi.',
            'username.string' => 'Username harus berupa string.',
            'username.min' => 'Username minimal 3 karakter.',
            'username.unique' => 'Username sudah terdaftar.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);
    }
    private function updateData(): void
    {
        $this->user->update([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'is_admin' => $this->is_admin ? 1 : 0,
        ]);
    }
    public function render()
    {
        return view('livewire.edit-user');
    }
}
