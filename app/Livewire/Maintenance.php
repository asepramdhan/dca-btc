<?php

namespace App\Livewire;

use App\Traits\MiniToast;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Maintenance extends Component
{
    use MiniToast;
    // Menyimpan status maintenance setiap halaman
    public array $pages = [];
    // Daftar halaman yang bisa diatur status maintenancenya
    public array $availablePages = [
        'dashboard',
        'investasi',
        'dana-darurat',
        'dana-harian',
        'transactions',
        'voucher',
        'exchange',
        'profil',
        'pin',
        'reset-password',
        'upgrade',
    ];
    // Inisialisasi data saat komponen dimount
    public function mount(): void
    {
        // Ambil data dari cache, jika tidak ada set default semua false
        $this->pages = Cache::get('maintenance_pages', array_fill_keys($this->availablePages, false));
    }
    // Fungsi untuk toggle status maintenance pada halaman tertentu
    public function toggle($page): void
    {
        // Ambil status saat ini, default false jika belum ada
        $current = $this->pages[$page] ?? false;
        // Toggle status
        $this->pages[$page] = !$current;
        // Simpan perubahan ke cache
        Cache::put('maintenance_pages', $this->pages);
        // Tampilkan notifikasi mini toast
        $this->miniToast("Halaman $page sekarang " . ($this->pages[$page] ? 'dimatikan' : 'diaktifkan'), timeout: 3000);
    }
    public function render()
    {
        return view('livewire.maintenance');
    }
}
