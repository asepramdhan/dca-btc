<?php

namespace App\Livewire;

use App\Models\User;
use App\Traits\MiniToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Pin extends Component
{
    use MiniToast;
    // Table headers configuration
    public $headers = [
        ['key' => 'name', 'label' => 'Nama Lengkap'],
        ['key' => 'pin', 'label' => 'PIN'],
        ['key' => 'updated_at', 'label' => 'Terakhir diubah'],
        ['key' => 'actions', 'label' => '', 'class' => 'w-32'], // Lebar tetap
    ];
    // Component properties
    public int $pin = 0;
    public bool $pinModal = false;
    public $deleteModal = false;
    public $selectedId;
    public int|null $pendingCreatePin = null;
    // Show modal to create or update PIN
    public function createPin(int $id): void
    {
        $this->reset('pin'); // Reset input setiap buka modal
        $this->pendingCreatePin = $id;
        $this->pinModal = true;
    }
    // Store the new PIN to the database
    public function storePin(): void
    {
        $this->validate([
            'pin' => 'required|numeric|digits:4',
        ], messages: [
            'pin.required' => 'PIN harus diisi.',
            'pin.numeric' => 'PIN harus berupa angka.',
            'pin.digits' => 'PIN harus terdiri dari 4 angka.',
        ]);
        $this->storeData();
        $this->miniToast('Berhasil menyimpan PIN', timeout: 3000);
        $this->pinModal = false;
    }
    // Update existing PIN
    private function storeData(): void
    {
        User::find($this->pendingCreatePin)->update([
            'pin' => $this->pin
        ]);
    }
    public function confirmDelete($id): void
    {
        $this->selectedId = $id;
        $this->deleteModal = true;
    }
    public function deleteConfirmed()
    {
        $this->deleteData();
        $this->deleteModal = false;
        $this->miniToast('PIN berhasil dihapus.', timeout: 3000);
    }
    private function deleteData()
    {
        User::find($this->selectedId)->update([
            'pin' => null
        ]);
    }
    public function render()
    {
        return view('livewire.pin', [
            'pins' => User::where('id', Auth::user()->id)->get(),
        ]);
    }
}
