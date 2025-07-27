<?php

namespace App\Livewire;

use App\Traits\MiniToast;
use Livewire\Component;

class EditPaket extends Component
{
    use MiniToast;
    public $paket, $name, $price, $duration, $description;
    public bool $is_active = false; // Status admin (boolean)
    public $durations = [
        ['id' => '30', 'name' => '30 Hari (1 Bulan)'],
        ['id' => '60', 'name' => '60 Hari (2 Bulan)'],
        ['id' => '365', 'name' => '365 Hari (1 Tahun)'],
    ];
    public function mount(): void
    {
        $this->name = $this->paket->name;
        $this->price = $this->paket->price;
        $this->duration = $this->paket->duration;
        $this->is_active = (bool) $this->paket->is_active;
        $this->description = $this->paket->description;
    }
    public function updatePaket(): void
    {
        $this->validasiPaket();
        $this->updateData();
        $this->miniToast('Paket berhasil diubah', redirectTo: '/admin/paket');
    }
    public function validasiPaket(): void
    {
        $this->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'duration' => 'required',
            'description' => 'required|max:255',
        ], messages: [
            'name.required' => 'Nama paket harus diisi.',
            'name.max' => 'Nama paket tidak boleh lebih dari 255 karakter.',
            'price.required' => 'Harga paket harus diisi.',
            'price.numeric' => 'Harga paket harus berupa angka.',
            'duration.required' => 'Durasi paket harus dipilih.',
            'description.required' => 'Deskripsi paket harus diisi.',
            'description.max' => 'Deskripsi paket tidak boleh lebih dari 255 karakter.',
        ]);
    }
    private function updateData(): void
    {
        $this->paket->update([
            'name' => $this->name,
            'price' => $this->price,
            'duration' => $this->duration,
            'is_active' => $this->is_active ? 1 : 0,
            'description' => $this->description
        ]);
    }
    public function render()
    {
        return view('livewire.edit-paket');
    }
}
