<?php

namespace App\Livewire;

use App\Models\Transaction;
use Carbon\Carbon;
use App\Traits\MiniToast;
use Livewire\Component;
use Livewire\WithPagination;

class AdminTransactions extends Component
{
    use MiniToast, WithPagination;
    public $search = '';
    public bool $paymentCheckDrawer = false;
    public $transaction = [];
    public $tanggal = '', $userName = '', $idTransaksi = '', $nominal = '', $tipePembayaran = '', $status = '', $keterangan = '';

    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'created_at', 'label' => 'Tanggal & Waktu'],
        ['key' => 'user.name', 'label' => 'Nama User'], // asumsi relasi user
        ['key' => 'package.name', 'label' => 'Nama Paket'], // asumsi relasi package
        ['key' => 'order_id', 'label' => 'ID Pesanan'],
        ['key' => 'payment_type', 'label' => 'Tipe Pembayaran'],
        ['key' => 'status', 'label' => 'Status'],
        ['key' => 'amount', 'label' => 'Jumlah'],
    ];
    public function paymentCheck($id): void
    {
        $this->paymentCheckDrawer = true;
        $transaction = Transaction::findOrFail($id)->load('user', 'package');
        $this->transaction = $transaction;
        $this->tanggal = $transaction->created_at->format('d M Y H:i');
        $this->userName = $transaction->user->name;
        $this->idTransaksi = $transaction->transaction_id;
        $this->nominal = number_format($transaction->amount, 0, ',', '.');
        $this->tipePembayaran = $transaction->payment_type;
        $this->status = $transaction->status;
        $this->keterangan = $transaction->package->name;
    }
    public function confirmPayment(): void
    {
        $this->updateData();
        $this->paymentCheckDrawer = false;
        $this->miniToast('Akun berhasil diupgrade', redirectTo: '/admin/transactions');
    }
    private function updateData(): void
    {
        $transaction = Transaction::findOrFail($this->transaction['id']);
        $transaction->update([
            'status' => 'success',
        ]);

        $transaction->user->update([
            'account_type' => 'premium',
            'premium_until' => Carbon::now()->addDays((int) $transaction->package->duration),
        ]);
    }
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
