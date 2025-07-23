<?php

namespace App\Livewire;

use App\Models\Exchange as ModelsExchange;
use App\Traits\MiniToast;
use Livewire\Component;

class Exchange extends Component
{
    use MiniToast;
    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'created_at', 'label' => 'Tanggal'],
        ['key' => 'name', 'label' => 'Nama Exchange'],
        ['key' => 'fee_buy', 'label' => 'Fee Beli'],
        ['key' => 'fee_sell', 'label' => 'Fee Jual'],
        ['key' => 'user_id', 'label' => 'Pembuat'],
    ];
    public $deleteModal = false;
    public $selectedId;
    public function confirmDelete($id)
    {
        $this->selectedId = $id;
        $this->deleteModal = true;
    }
    public function deleteConfirmed()
    {
        ModelsExchange::find($this->selectedId)?->delete();
        $this->deleteModal = false;
        $this->miniToast(
            type: 'success',
            title: 'Data berhasil dihapus.',
        );
    }
    public function render()
    {
        return view('livewire.exchange', [
            'exchanges' => ModelsExchange::with('user')->paginate(10),
        ]);
    }
}
