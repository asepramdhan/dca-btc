<?php

namespace App\Livewire;

use App\Models\Exchange as ExchangeModel;
use App\Traits\MiniToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Exchange extends Component
{
    use MiniToast;
    public $search = '';
    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'created_at', 'label' => 'Tanggal'],
        ['key' => 'name', 'label' => 'Nama Exchange'],
        ['key' => 'fee_buy', 'label' => 'Fee Beli'],
        ['key' => 'fee_sell', 'label' => 'Fee Jual'],
        ['key' => 'user_id', 'label' => 'Pembuat'],
    ];
    // Component state variables
    public string $pin = '';
    public bool $pinModal = false;
    public int|null $pendingDeleteId = null;
    // Show PIN modal for delete confirmation
    public function confirmDelete(int $id): void
    {
        $this->pendingDeleteId = $id;
        $this->pinModal = true;
    }
    public function confirmPin(): void
    {
        $this->validate([
            'pin' => 'required|numeric|digits:4',
        ], messages: [
            'pin.required' => 'PIN harus diisi.',
            'pin.numeric' => 'PIN harus berupa angka.',
            'pin.digits' => 'PIN harus terdiri dari 4 angka.',
        ]);
        if ($this->pin !== Auth::user()->pin) {
            $this->miniToast('PIN salah!', 'error');
            return;
        }
        $this->deleteData();
        $this->miniToast('Data berhasil dihapus', timeout: 3000);
        $this->pinModal = false;
    }
    private function deleteData(): void
    {
        ExchangeModel::find($this->pendingDeleteId)->delete();
    }
    public function render()
    {
        return view('livewire.exchange', [
            'exchanges' => ExchangeModel::with('user')->paginate(10),
            'exchanges' => ExchangeModel::where(function ($query) {
                if ($this->search) {
                    $query->whereDate('created_at', 'like', '%' . $this->search . '%')
                        ->orWhereRaw("DATE_FORMAT(created_at, '%d-%m-%Y %H:%i') LIKE '%" . $this->search . "%'")
                        ->orWhere('name', 'like', '%' . $this->search . '%');
                }
            })->with('user')->paginate(10),
        ]);
    }
}
