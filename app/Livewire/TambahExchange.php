<?php

namespace App\Livewire;

use App\Models\Exchange;
use App\Traits\MiniToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TambahExchange extends Component
{
    use MiniToast;
    public $name, $fee_buy, $fee_sell;
    public function tambahLagi(): void
    {
        $this->simpanDana();

        $this->reset('name', 'fee_buy', 'fee_sell');
        $this->miniToast(
            type: 'success',
            title: 'Exchange Ditambahkan. Silakan tambah lagi.',
            timeout: 4000, // dalam milidetik, misal 5 detik
        );
        // Dispatch event untuk autofocus kembali
        $this->dispatch('focus-name');
    }
    public function tambahDanKembali(): void
    {
        $this->simpanDana();

        $this->miniToast(
            type: 'success',
            title: 'Exchange Ditambahkan.',
            redirectTo: route('exchange'),
        );
    }
    private function simpanDana(): void
    {
        $data = $this->validate([
            'name' => 'required',
            'fee_buy' => 'required',
            'fee_sell' => 'required',
        ], messages: [
            'name.required' => 'Nama exchange harus diisi.',
            'fee_buy.required' => 'Fee beli harus diisi.',
            'fee_sell.required' => 'Fee jual harus diisi.',
        ]);

        $data['user_id'] = Auth::id();
        Exchange::create($data);
    }
    public function render()
    {
        return view('livewire.tambah-exchange');
    }
}
