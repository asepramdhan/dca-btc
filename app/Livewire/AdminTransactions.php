<?php

namespace App\Livewire;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AdminTransactions extends Component
{
    use WithPagination;
    public $search = '';
    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'created_at', 'label' => 'Tanggal & Waktu'],
        ['key' => 'user.name', 'label' => 'Nama User'], // asumsi relasi user
        ['key' => 'package.name', 'label' => 'Nama Paket'], // asumsi relasi package
        ['key' => 'order_id', 'label' => 'ID Pesanan'],
        ['key' => 'transaction_id', 'label' => 'ID Transaksi'],
        ['key' => 'payment_type', 'label' => 'Tipe Pembayaran'],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'amount', 'label' => 'Jumlah'],
    ];
    public function render()
    {
        return view('livewire.admin-transactions', [
            'transactions' => Transaction::where(function ($query) {
                if ($this->search) {
                    $query->whereDate('created_at', 'like', '%' . $this->search . '%')
                        ->orWhereRaw("DATE_FORMAT(created_at, '%d-%m-%Y %H:%i') LIKE '%" . $this->search . "%'")
                        ->orWhereHas('user', function ($query) {
                            $query->where('name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('order_id', 'like', '%' . $this->search . '%')
                        ->orWhere('payment_type', 'like', '%' . $this->search . '%');
                }
            })->latest()->paginate(10),
        ]);
    }
}
