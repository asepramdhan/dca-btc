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
    public $search = '';
    public $investasiSum = 0;
    public $deleteModal = false;
    public $selectedId;
    // Table headers configuration
    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'created_at', 'label' => 'Tanggal'],
        ['key' => 'amount', 'label' => 'Jumlah (Rp)'],
        ['key' => 'price', 'label' => 'Harga Beli/Jual'],
        ['key' => 'fee', 'label' => 'Fee'],
        ['key' => 'quantity', 'label' => 'Jumlah BTC'],
        ['key' => 'exchange_id', 'label' => 'Exchange'],
        ['key' => 'type', 'label' => 'Tipe'],
        ['key' => 'description', 'label' => 'Keterangan'],
    ];
    public function mount(): void
    {
        // Simpan ID user saat ini agar tidak memanggil Auth berkali-kali
        $userId = Auth::id();
        // Ambil total amount dan quantity dari investasi (DCA), dikelompokkan berdasarkan tipe (beli/jual)
        $dca = Dca::selectRaw("type, SUM(amount) as amount_total, SUM(quantity) as quantity_total")
            ->where('user_id', $userId)->groupBy('type')->get()->keyBy('type');
        // Hitung total modal investasi = total beli - total jual
        $this->investasiSum = ($dca['beli']->amount_total ?? 0) - ($dca['jual']->amount_total ?? 0);
    }
    public function confirmDelete($id)
    {
        $this->selectedId = $id;
        $this->deleteModal = true;
    }
    public function deleteConfirmed()
    {
        Dca::find($this->selectedId)?->delete();
        $this->deleteModal = false;
        $this->miniToast('Data berhasil dihapus.');
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        return view('livewire.investasi', [
            'investasis' => Dca::where(function ($query) {
                $query->where('user_id', Auth::user()->id);
                if ($this->search) {
                    $query->whereDate('created_at', 'like', '%' . $this->search . '%')
                        ->orWhereRaw("DATE_FORMAT(created_at, '%d-%m-%Y %H:%i') LIKE '%" . $this->search . "%'")
                        ->orWhere('type', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                }
            })->with('exchange')->latest()->paginate(10),
            'invesSum' => $this->investasiSum,
        ]);
    }
}
