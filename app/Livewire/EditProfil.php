<?php

namespace App\Livewire;

use App\Traits\MiniToast;
use Livewire\Component;

class EditProfil extends Component
{
    use MiniToast;
    public $user, $name, $username, $email;
    public function mount(): void
    {
        $this->name = $this->user->name;
        $this->username = $this->user->username;
        $this->email = $this->user->email;
    }
    public function updateProfil(): void
    {
        $this->updateData();
        $this->miniToast('Profil berhasil diubah', redirectTo: '/auth/profil');
    }
    private function updateData()
    {
        $data = $this->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $this->user->id,
            'email' => 'required|email|unique:users,email,' . $this->user->id,
        ], messages: [
            'name.required' => 'Nama lengkap harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah terdaftar',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
        ]);

        $this->user->update($data);
    }
    public function render()
    {
        return view('livewire.edit-profil');
    }
}
