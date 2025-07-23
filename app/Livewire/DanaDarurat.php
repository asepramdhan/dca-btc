<?php

namespace App\Livewire;

use App\Models\Emergency;
use App\Traits\MiniToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DanaDarurat extends Component
{
    use MiniToast, WithPagination;
    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'created_at', 'label' => 'Tanggal'],
        ['key' => 'amount', 'label' => 'Jumlah'],
        ['key' => 'type', 'label' => 'Tipe', 'class' => 'hidden sm:table-cell'],
        ['key' => 'description', 'label' => 'Keterangan', 'class' => 'hidden sm:table-cell'],
    ];
    public $danaDaruratSum;
    public function mount()
    {
        $userId = Auth::id();

        $pengeluaran = Emergency::where('user_id', $userId)->where('type', 'pengeluaran')->sum('amount');
        $pemasukan = Emergency::where('user_id', $userId)->where('type', 'pemasukan')->sum('amount');

        $this->danaDaruratSum = $pemasukan - $pengeluaran;
    }
    public $deleteModal = false;
    public $selectedId;
    public function confirmDelete($id)
    {
        $this->selectedId = $id;
        $this->deleteModal = true;
    }
    public function deleteConfirmed()
    {
        Emergency::find($this->selectedId)?->delete();
        $this->deleteModal = false;
        $this->miniToast('Data berhasil dihapus.');
    }
    public function render()
    {
        return view('livewire.dana-darurat', [
            'danaDarurats' => Emergency::where('user_id', Auth::user()->id)->latest()->paginate(10),
            'daruratSum' => $this->danaDaruratSum
        ]);
    }
}
