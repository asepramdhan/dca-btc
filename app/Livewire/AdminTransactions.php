<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Component;

class AdminTransactions extends Component
{
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
            'transactions' => Transaction::latest()->paginate(10),
        ]);
    }
}
