<?php

namespace App\Livewire;

use App\Models\Package;
use App\Traits\MiniToast;
use Livewire\Component;

class TambahPaket extends Component
{
    use MiniToast;
    public $name, $price, $description;
    public $duration =  '30';
    public $durations = [
        ['id' => '30', 'name' => '30 Hari (1 Bulan)'],
        ['id' => '60', 'name' => '60 Hari (2 Bulan)'],
        ['id' => '365', 'name' => '365 Hari (1 Tahun)'],
    ];
    public function tambahLagi(): void
    {
        $this->simpanData();

        $this->reset('name', 'price', 'description', 'duration');
        $this->duration = '30';
        $this->miniToast(
            type: 'success',
            title: 'Paket Berhasil Ditambahkan. Silakan tambah lagi.',
            timeout: 4000, // dalam milidetik, misal 5 detik
        );
        // Dispatch event untuk autofocus kembali
        // $this->dispatch('focus-jumlah');
    }
    public function tambahDanKembali(): void
    {
        $this->simpanData();

        $this->miniToast(
            type: 'success',
            title: 'Paket Ditambahkan.',
            redirectTo: '/admin/paket',
        );
    }
    private function simpanData(): void
    {
        $data = $this->validate([
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
            'description.required' => 'Keterangan harus diisi.',
            'description.max' => 'Keterangan tidak boleh lebih dari 255 karakter.',
        ]);

        Package::create($data);
    }
    public function render()
    {
        return view('livewire.tambah-paket');
    }
}
