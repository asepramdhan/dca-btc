<?php

namespace App\Livewire;

use App\Models\Dca;
use App\Models\Exchange;
use App\Traits\MiniToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;

class TambahInvestasi extends Component
{
    use MiniToast;
    public $exchange_id = 1;
    public $created_at, $amount, $price, $description, $quantity;
    public $type = 'beli';
    public $configWithTime = [
        'enableTime' => true,
        'dateFormat' => 'Y-m-d H:i', // Format lengkap tanggal + jam
    ];
    public $types = [
        ['id' => 'beli', 'name' => 'Beli'],
        ['id' => 'jual', 'name' => 'Jual'],
    ];
    public function tambahLagi(): void
    {
        $this->simpanDana();

        $this->reset('created_at', 'exchange_id', 'amount', 'description', 'type', 'price');
        $this->exchange_id = 1;
        $this->type = 'beli';
        $this->miniToast('Dana Investasi Ditambahkan. Silakan tambah lagi.', timeout: 4000);
        // Dispatch event untuk autofocus kembali
        $this->dispatch('focus-jumlah');
    }
    public function tambahDanKembali(): void
    {
        $this->simpanDana();

        $this->miniToast('Dana Investasi Ditambahkan.', redirectTo: '/auth/investasi');
    }
    private function simpanDana(): void
    {
        $data = $this->validate([
            'created_at' => 'required|date',
            'exchange_id' => 'required',
            'amount' => 'required|numeric',
            'price' => 'required|numeric',
            'type' => 'required',
            'description' => 'required|max:255',
        ], messages: [
            'created_at.required' => 'Tanggal harus diisi.',
            'created_at.date' => 'Tanggal harus berupa tanggal.',
            'exchange_id.required' => 'Pilih salah satu exchange.',
            'amount.required' => 'Jumlah dana harus diisi.',
            'amount.numeric' => 'Jumlah dana harus berupa angka.',
            'price.required' => 'Harga harus diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'type.required' => 'Tipe harus dipilih.',
            'description.required' => 'Keterangan harus diisi.',
            'description.max' => 'Keterangan tidak boleh lebih dari 255 karakter.',
        ]);

        $data['user_id'] = Auth::id();
        // Ambil exchange & hitung fee
        $exchange = Exchange::findOrFail($data['exchange_id']);
        $data['exchange_id'] = $exchange->id;
        $feeStr = $data['type'] === 'beli' ? $exchange->fee_buy : $exchange->fee_sell;
        $fee = (float) str_replace('%', '', $feeStr) / 100;
        // Hitung quantity setelah fee
        $quantity = $data['amount'] / $data['price'];
        $quantityAfterFee = $quantity - ($quantity * $fee);
        // Format quantity ke 8 desimal
        $data['quantity'] = number_format($quantityAfterFee, 8, '.', '');
        Dca::create($data);
    }
    public function render()
    {
        return view('livewire.tambah-investasi', [
            // Daftar exchange untuk select option
            'exchanges' => Exchange::all()->map(fn($exchange) => [
                'id' => $exchange->id,
                'name' => Str::upper($exchange->name),
            ])->toArray(),
        ]);
    }
}
