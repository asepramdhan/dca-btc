<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\User;
use App\Traits\MiniToast;
use Illuminate\Support\Collection;
use Livewire\Component;

class EditVoucher extends Component
{
    use MiniToast;
    public ?int $selectUserId = null;
    public Collection $searchUsers;
    public $packages, $packageId = 1;
    public $voucher;
    public function mount(): void
    {
        $this->search();
        $this->packages = Package::all();
        $this->selectUserId = $this->voucher->user_id;
        $this->packageId = $this->voucher->package_id;
    }

    public function search(string $value = ''): void
    {
        $selectedOption = collect(); // Inisialisasi sebagai koleksi kosong
        if ($this->selectUserId) {
            $selectedOption = $this->users->where('id', $this->selectUserId)->get();
        }

        // Mengambil 5 pengguna yang namanya cocok dengan nilai pencarian, diurutkan berdasarkan nama.
        $this->searchUsers = User::query()
            ->where('name', 'like', '%' . $value . '%')
            ->take(5)
            ->orderBy('name')
            ->get()
            ->merge($selectedOption->filter()); // Memfilter nilai null jika selectedOption kosong
    }
    public function editVoucher(): void
    {
        $this->validasiVoucher();
        $this->updateData();
        $this->miniToast('Voucher berhasil diubah', redirectTo: '/admin/voucher');
    }
    private function validasiVoucher(): void
    {
        $this->validate([
            'selectUserId' => 'required',
            'packageId' => 'required',
        ], messages: [
            'selectUserId.required' => 'Nama user harus diisi.',
            'packageId.required' => 'Paket harus dipilih.',
        ]);
    }
    private function updateData(): void
    {
        $this->voucher->update([
            'user_id' => $this->selectUserId,
            'package_id' => $this->packageId,
        ]);
    }
    public function render()
    {
        return view('livewire.edit-voucher');
    }
}
