<?php

namespace App\Livewire;

use App\Models\Emergency;
use App\Traits\MiniToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TambahDanaDarurat extends Component
{
    use MiniToast;
    public $amount, $description;
    public $type = 'pemasukan';
    public $types =
    [
        ['id' => 'pemasukan', 'name' => 'Pemasukan'],
        ['id' => 'pengeluaran', 'name' => 'Pengeluaran'],
    ];
    public function tambahLagi(): void
    {
        $this->simpanDana();

        $this->reset('amount', 'description', 'type');
        $this->type = 'pemasukan';
        $this->miniToast('Dana Darurat Ditambahkan. Silakan tambah lagi.', timeout: 4000);
        // Dispatch event untuk autofocus kembali
        $this->dispatch('focus-jumlah');
    }
    public function tambahDanKembali(): void
    {
        $this->simpanDana();

        $this->miniToast('Dana Darurat Ditambahkan.', redirectTo: '/auth/dana-darurat');
    }
    private function simpanDana(): void
    {
        $data = $this->validate([
            'amount' => 'required|numeric',
            'type' => 'required',
            'description' => 'required|max:255',
        ], messages: [
            'amount.required' => 'Jumlah dana harus diisi.',
            'amount.numeric' => 'Jumlah dana harus berupa angka.',
            'type.required' => 'Tipe harus dipilih.',
            'description.required' => 'Keterangan harus diisi.',
            'description.max' => 'Keterangan tidak boleh lebih dari 255 karakter.',
        ]);

        $data['user_id'] = Auth::id();
        Emergency::create($data);
    }
    public function render()
    {
        return view('livewire.tambah-dana-darurat');
    }
}
