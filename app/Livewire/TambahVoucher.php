<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\User;
use App\Models\Voucher;
use App\Traits\MiniToast;
use Illuminate\Support\Collection;
use Livewire\Component;

class TambahVoucher extends Component
{
    use MiniToast;
    public ?int $selectUserId = null;
    public Collection $searchUsers;
    public $packages, $packageId = 1;

    public function mount(): void
    {
        $this->search();
        $this->packages = Package::all();
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
    public function tambahVoucher(): void
    {
        $this->validasiVoucher();
        $this->tambahData();
        $this->miniToast('Voucher berhasil ditambahkan', redirectTo: '/admin/voucher');
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
    private function tambahData(): void
    {
        Voucher::create([
            'user_id' => $this->selectUserId,
            'package_id' => $this->packageId,
            'code' => 'V-' . mt_rand(100000, 999999),
        ]);
    }
    public function render()
    {
        // Merender tampilan Livewire untuk komponen ini.
        return view('livewire.tambah-voucher');
    }
}
