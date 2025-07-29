<?php

namespace App\Livewire;

use App\Traits\MiniToast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditExchange extends Component
{
    use MiniToast;
    public $exchange, $name, $fee_buy, $fee_sell;
    public function mount(): void
    {
        $this->name = $this->exchange->name;
        $this->fee_buy = $this->exchange->fee_buy;
        $this->fee_sell = $this->exchange->fee_sell;
    }
    public function editExchange(): void
    {
        $data = $this->validate([
            'name' => 'required|max:255',
            'fee_buy' => 'required',
            'fee_sell' => 'required',
        ], messages: [
            'name.required' => 'Nama harus diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'fee_buy.required' => 'Fee beli harus diisi.',
            'fee_sell.required' => 'Fee jual harus diisi.',
        ]);
        $data['user_id'] = Auth::user()->id;
        $this->exchange->update($data);
        $this->miniToast('Exchange Berhasil Diubah', redirectTo: '/auth/exchange');
    }
    public function render()
    {
        return view('livewire.edit-exchange');
    }
}
