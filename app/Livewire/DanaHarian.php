<?php

namespace App\Livewire;

use App\Models\Daily;
use App\Traits\MiniToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DanaHarian extends Component
{
    use MiniToast;
    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'created_at', 'label' => 'Tanggal'],
        ['key' => 'amount', 'label' => 'Jumlah'],
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
        Daily::find($this->selectedId)?->delete();
        $this->deleteModal = false;
        $this->miniToast(
            type: 'success',
            title: 'Data berhasil dihapus.',
        );
    }
    public function render()
    {
        return view('livewire.dana-harian', [
            'danaHarians' => Daily::where('user_id', Auth::user()->id)->latest()->paginate(10),
        ]);
    }
}
