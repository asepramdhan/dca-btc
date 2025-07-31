<?php

namespace App\Livewire;

use App\Models\Voucher as ModelsVoucher;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Voucher extends Component
{
    use WithPagination;
    public $search = '';
    public $deleteModal = false;
    public $selectedId;
    public $voucherModal = false;
    public $currentVoucherCode = '';

    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'created_at', 'label' => 'Tanggal'],
        ['key' => 'package.name', 'label' => 'Paket'],
        ['key' => 'is_active', 'label' => 'Status'],
    ];

    public function viewVoucher($voucherId)
    {
        $voucher = ModelsVoucher::find($voucherId);
        if ($voucher) {
            $this->currentVoucherCode = $voucher->code;
            $this->voucherModal = true;
        }
    }

    public function render()
    {
        return view('livewire.voucher', [
            'vouchers' => ModelsVoucher::where('user_id', Auth::id())->where(function ($query) {
                if ($this->search) {
                    $searchTerm = Str::lower($this->search); // Konversi pencarian ke huruf kecil sekali saja

                    $query->whereDate('created_at', 'like', '%' . $searchTerm . '%')
                        ->orWhereRaw("DATE_FORMAT(created_at, '%d-%m-%Y %H:%i') LIKE '%" . $searchTerm . "%'")
                        ->orWhereHas('package', function ($q) use ($searchTerm) { // Cari juga di nama paket
                            $q->where('name', 'like', '%' . $searchTerm . '%');
                        });

                    // Logika untuk mencari berdasarkan status 'Tersedia' atau 'Digunakan'
                    if ($searchTerm === 'tersedia') {
                        $query->orWhere('is_active', 1); // 1 = Tersedia
                    } elseif ($searchTerm === 'digunakan') {
                        $query->orWhere('is_active', 0); // 0 = Digunakan
                    }
                    // Tambahan: Jika ingin mencari berdasarkan ID voucher juga (karena ada kolom ID)
                    if (is_numeric($searchTerm)) {
                        $query->orWhere('id', $searchTerm);
                    }
                }
            })->latest()->paginate(10),
        ]);
    }
}
