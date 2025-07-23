<?php

namespace App\Livewire;

use App\Traits\MiniToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditDanaDarurat extends Component
{
    use MiniToast;
    public $emergency, $user_id, $amount, $description, $type;
    public $types =
    [
        ['id' => 'pemasukan', 'name' => 'Pemasukan'],
        ['id' => 'pengeluaran', 'name' => 'Pengeluaran'],
    ];
    public function mount(): void
    {
        $this->amount = $this->emergency->amount;
        $this->description = $this->emergency->description;
        $this->type = $this->emergency->type;
    }
    public function editDanaDarurat(): void
    {
        $dataValid = $this->validate([
            'amount' => 'required|numeric',
            'type' => 'required',
            'description' => 'required|max:255',
        ], messages: [
            'amount.required' => 'Jumlah tidak boleh kosong',
            'amount.numeric' => 'Jumlah harus berupa angka',
            'type.required' => 'Tipe tidak boleh kosong',
            'description.required' => 'Deskripsi tidak boleh kosong',
            'description.max' => 'Deskripsi tidak boleh lebih dari 255 karakter',
        ]);
        $dataValid['user_id'] = Auth::user()->id;
        $this->emergency->update($dataValid);
        $this->miniToast('Dana Darurat Berhasil Diubah', redirectTo: route('dana-darurat'));
    }
    public function render()
    {
        return view('livewire.edit-dana-darurat');
    }
}
