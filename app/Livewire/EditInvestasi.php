<?php

namespace App\Livewire;

use App\Models\Exchange;
use App\Traits\MiniToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;

class EditInvestasi extends Component
{
    use MiniToast;
    public $exchange_id = 1;
    public $dca, $created_at, $amount, $price, $description, $quantity;
    public $type = 'beli';
    public $configWithTime = [
        'enableTime' => true,
        'dateFormat' => 'Y-m-d H:i', // Format lengkap tanggal + jam
    ];
    public $types = [
        ['id' => 'beli', 'name' => 'Beli'],
        ['id' => 'jual', 'name' => 'Jual'],
    ];
    public function mount(): void
    {
        $this->exchange_id = $this->dca->exchange_id;
        $this->created_at = $this->dca->created_at;
        $this->amount = $this->dca->amount;
        $this->price = $this->dca->price;
        $this->description = $this->dca->description;
        $this->quantity = $this->dca->quantity;
        $this->type = $this->dca->type;
    }
    public function editInvestasi(): void
    {
        $data = $this->validate([
            'exchange_id' => 'required',
            'created_at' => 'required|date',
            'amount' => 'required|numeric',
            'price' => 'required|numeric',
            'type' => 'required',
            'description' => 'required|max:255',
        ], messages: [
            'exchange_id.required' => 'Pilih salah satu exchange.',
            'created_at.required' => 'Tanggal harus diisi.',
            'created_at.date' => 'Tanggal harus berupa tanggal.',
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
        $data['quantity'] = $quantity * (1 - $fee);
        $this->dca->update($data);
        $this->miniToast(type: 'success', title: 'Dana Investasi Diubah.', redirectTo: route('investasi'));
    }
    public function render()
    {
        return view('livewire.edit-investasi', [
            // Daftar exchange untuk select option
            'exchanges' => Exchange::all()->map(fn($exchange) => [
                'id' => $exchange->id,
                'name' => Str::upper($exchange->name),
            ])->toArray(),
        ]);
    }
}
