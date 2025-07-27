<?php

namespace App\Livewire;

use App\Models\Package;
use App\Traits\MiniToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Paket extends Component
{
    use MiniToast;
    public string $pin = '';
    public bool $pinModal = false;
    public int|null $pendingDeleteId = null;
    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'name', 'label' => 'Nama Paket'],
        ['key' => 'price', 'label' => 'Harga'],
        ['key' => 'description', 'label' => 'Keterangan'],
        ['key' => 'is_active', 'label' => 'Status'],
        ['key' => 'created_at', 'label' => 'Tgl Dibuat'],
        ['key' => 'updated_at', 'label' => 'Tgl Diubah'],
    ];
    public function confirmDelete(int $id): void
    {
        $this->pendingDeleteId = $id;
        $this->pinModal = true;
    }
    public function confirmPin(): void
    {
        $this->validate([
            'pin' => 'required|numeric|digits:4',
        ], messages: [
            'pin.required' => 'PIN harus diisi.',
            'pin.numeric' => 'PIN harus berupa angka.',
            'pin.digits' => 'PIN harus terdiri dari 4 angka.',
        ]);
        if ($this->pin !== Auth::user()->pin) {
            $this->miniToast('PIN salah!', 'error');
            return;
        }
        $this->deleteData();
        $this->miniToast('Paket berhasil dinonaktifkan', timeout: 3000);
        $this->pinModal = false;
    }
    private function deleteData()
    {
        Package::findOrFail($this->pendingDeleteId)->update(['is_active' => false]);
    }
    public function render()
    {
        return view('livewire.paket', [
            'pakets' => Package::paginate(10),
        ]);
    }
}
