<?php

namespace App\Livewire;

use App\Traits\MiniToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditDanaHarian extends Component
{
    use MiniToast;
    public $daily, $amount, $description, $type = 'pemasukan';
    public $types =
    [
        ['id' => 'pemasukan', 'name' => 'Pemasukan'],
        ['id' => 'pengeluaran', 'name' => 'Pengeluaran'],
    ];
    public function mount(): void
    {
        $this->amount = $this->daily->amount;
        $this->description = $this->daily->description;
        $this->type = $this->daily->type;
    }
    public function editDanaHarian(): void
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
        $data['user_id'] = Auth::user()->id;
        $this->daily->update($data);
        $this->miniToast('Dana Harian Berhasil Diubah', redirectTo: '/auth/dana-harian');
    }
    public function render()
    {
        return view('livewire.edit-dana-harian');
    }
}
