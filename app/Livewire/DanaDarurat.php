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

    public $search = '';
    public $danaDaruratSum;
    public $deleteModal = false;
    public $selectedId;

    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'created_at', 'label' => 'Tanggal'],
        ['key' => 'amount', 'label' => 'Jumlah'],
        ['key' => 'type', 'label' => 'Tipe', 'class' => 'hidden sm:table-cell'],
        ['key' => 'description', 'label' => 'Keterangan', 'class' => 'hidden sm:table-cell'],
    ];

    public function mount()
    {
        $userId = Auth::id();

        $emergency = Emergency::selectRaw("type, SUM(amount) as total")
            ->where('user_id', $userId)
            ->groupBy('type')
            ->get()
            ->keyBy('type');

        $pemasukan  = $emergency['pemasukan']->total  ?? 0;
        $pengeluaran = $emergency['pengeluaran']->total ?? 0;

        $this->danaDaruratSum = $pemasukan - $pengeluaran;
    }

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
            'danaDarurats' => Emergency::where(function ($query) {
                $query->where('user_id', Auth::user()->id);
                if ($this->search) {
                    $query->whereDate('created_at', 'like', '%' . $this->search . '%')
                        ->orWhereRaw("DATE_FORMAT(created_at, '%d-%m-%Y %H:%i') LIKE '%" . $this->search . "%'")
                        ->orWhere('type', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                }
            })->latest()->paginate(10),
            'daruratSum' => $this->danaDaruratSum,
        ]);
    }
}
