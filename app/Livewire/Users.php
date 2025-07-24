<?php

namespace App\Livewire;

use App\Models\User;
use App\Traits\MiniToast;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Users extends Component
{
    use MiniToast;
    public $search = '';
    public string $pin = '';
    public bool $pinModal = false;
    public int|null $pendingDeleteId = null;
    // Header tabel untuk tampilan data user
    public $headers = [
        ['key' => 'id', 'label' => '#', 'class' => 'bg-error/20 w-1'],
        ['key' => 'name', 'label' => 'Nama'],
        ['key' => 'username', 'label' => 'Username'],
        ['key' => 'email', 'label' => 'Email'],
        ['key' => 'role', 'label' => 'Role'],
        ['key' => 'account_type', 'label' => 'Akun'],
        ['key' => 'premium_until', 'label' => 'Berlaku'],
        ['key' => 'created_at', 'label' => 'Tgl Daftar'],
        ['key' => 'updated_at', 'label' => 'Tgl Diubah'],
    ];
    public function getPremiumStatus(User $user): string
    {
        if (!$user->premium_until) {
            return '-';
        }

        $diff = Carbon::now()->diff(Carbon::parse($user->premium_until));

        return $diff->invert
            ? "Expired {$diff->days} hari lalu"
            : ($diff->days > 0
                ? "{$diff->days} hari lagi"
                : ($diff->days === 0
                    ? 'Hari terakhir'
                    : 'Expired'));
    }
    // Show PIN modal for delete confirmation
    public function confirmDelete(int $id): void
    {
        $this->pendingDeleteId = $id;
        $this->pinModal = true;
    }
    public function confirmPin(): void
    {
        $this->validasiData();
        if ($this->pin !== Auth::user()->pin) {
            $this->miniToast('PIN salah!', 'error');
            return;
        }
        $this->deleteData();
        $this->miniToast('Data berhasil dihapus', timeout: 3000);
        $this->pinModal = false;
    }
    private function validasiData(): void
    {
        $this->validate([
            'pin' => 'required|numeric|digits:4',
        ], messages: [
            'pin.required' => 'PIN harus diisi.',
            'pin.numeric' => 'PIN harus berupa angka.',
            'pin.digits' => 'PIN harus terdiri dari 4 angka.',
        ]);
    }
    private function deleteData(): void
    {
        User::find($this->pendingDeleteId)->delete();
    }
    public function render()
    {
        return view('livewire.users', [
            'users' => User::where(function ($query) {
                if ($this->search) {
                    $query->whereDate('created_at', 'like', '%' . $this->search . '%')
                        ->orWhereRaw("DATE_FORMAT(created_at, '%d-%m-%Y %H:%i') LIKE '%" . $this->search . "%'")
                        ->orWhere('name', 'like', '%' . $this->search . '%')
                        ->orWhere('username', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('is_admin', $this->search === 'admin' ? 1 : ($this->search === 'user' ? 0 : $this->search))
                        ->orWhereDate('updated_at', 'like', '%' . $this->search . '%')
                        ->orWhereRaw("DATE_FORMAT(updated_at, '%d-%m-%Y %H:%i') LIKE '%" . $this->search . "%'")
                        ->orWhere('account_type', $this->search);
                }
            })->latest()->paginate(10),
        ]);
    }
}
