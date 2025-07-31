<?php

namespace App\Livewire;

use App\Models\Voucher;
use App\Traits\MiniToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminVoucher extends Component
{
    use MiniToast, WithPagination;
    public $search = '';
    public string $pin = '';
    public bool $pinModal = false;
    public int|null $pendingDeleteId = null;
    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'created_at', 'label' => 'Tanggal'],
        ['key' => 'user.name', 'label' => 'Pemilik'],
        ['key' => 'package.name', 'label' => 'Paket'],
        ['key' => 'code', 'label' => 'Kode Voucher'],
        ['key' => 'usage_limit', 'label' => 'Limit'],
        ['key' => 'used_count', 'label' => 'Penggunaan'],
        ['key' => 'is_active', 'label' => 'Status'],
        ['key' => 'updated_at', 'label' => 'Tgl Diubah'],
    ];
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
        $this->miniToast('Voucher berhasil dihapus!', timeout: 3000);
        $this->pinModal = false;
    }
    private function deleteData()
    {
        Voucher::findOrFail($this->pendingDeleteId)->delete();
    }
    public function render()
    {
        return view('livewire.admin-voucher', [
            'vouchers' => Voucher::where(function ($query) {
                if ($this->search) {
                    $query->whereDate('created_at', 'like', '%' . $this->search . '%')
                        ->orWhereRaw("DATE_FORMAT(created_at, '%d-%m-%Y %H:%i') LIKE '%" . $this->search . "%'")
                        ->orWhereHas('user', function ($query) {
                            $query->where('name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('code', 'like', '%' . $this->search . '%')
                        ->orWhereRaw("DATE_FORMAT(updated_at, '%d-%m-%Y %H:%i') LIKE '%" . $this->search . "%'");
                }
            })->latest()->paginate(10),
        ]);
    }
}
