<?php

namespace App\Livewire;

use App\Models\Dca;
use App\Traits\MiniToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Investasi extends Component
{
    use MiniToast, WithPagination;
    // Table headers configuration
    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'created_at', 'label' => 'Tanggal'],
        ['key' => 'amount', 'label' => 'Jumlah (Rp)'],
        ['key' => 'price', 'label' => 'Harga Beli/Jual'],
        ['key' => 'fee', 'label' => 'Fee', 'class' => 'hidden sm:table-cell'],
        ['key' => 'quantity', 'label' => 'Jumlah BTC', 'class' => 'hidden sm:table-cell'],
        ['key' => 'exchange_id', 'label' => 'Exchange', 'class' => 'hidden sm:table-cell'],
        ['key' => 'type', 'label' => 'Tipe', 'class' => 'hidden sm:table-cell'],
        ['key' => 'description', 'label' => 'Keterangan', 'class' => 'hidden sm:table-cell'],
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
        Dca::find($this->selectedId)?->delete();
        $this->deleteModal = false;
        $this->miniToast(
            type: 'success',
            title: 'Data berhasil dihapus.',
        );
    }
    public function render()
    {
        return view('livewire.investasi', [
            'investasis' => Dca::with('exchange')->where('user_id', Auth::user()->id)->latest()->paginate(10),
        ]);
    }
}
