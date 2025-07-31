<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Profil extends Component
{
    // Header tabel untuk tampilan data user
    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'name', 'label' => 'Nama Lengkap'],
        ['key' => 'username', 'label' => 'Nama Pengguna (Username)'],
        ['key' => 'email', 'label' => 'Email'],
        ['key' => 'created_at', 'label' => 'Tanggal Daftar'],
        ['key' => 'updated_at', 'label' => 'Terakhir diubah'],
    ];
    public function render()
    {
        return view('livewire.profil', [
            'users' => User::where('id', Auth::user()->id)->get(),
        ]);
    }
}
