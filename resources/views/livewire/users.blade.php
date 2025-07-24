<div>
  <x-header>
    <x-slot:middle class="!justify-end">
      <x-input icon="lucide.search" placeholder="Cari Nama, Username, E-mail, Role, Tipe akun, Tanggal daftar, Terakhir diubah . . ." wire:model.live='search' />
    </x-slot:middle>
    <x-slot:actions>
      <x-button icon="lucide.plus" class="btn-sm btn-ghost" :link="route('tambah-user')" />
    </x-slot:actions>
  </x-header>
  <!-- Tabel data user -->
  <x-table :headers="$headers" :rows="$users" striped with-pagination>
    <!-- Kolom nomor urut -->
    @scope('cell_id', $user)
    <strong>{{ $loop->iteration }}</strong>
    @endscope

    <!-- Kolom nama lengkap -->
    @scope('cell_name', $user)
    {{ Str::title($user->name) }}
    @endscope

    <!-- Kolom role -->
    @scope('cell_role', $user)
    <x-badge :value="$user->is_admin ? 'Admin' : 'User'" :class="$user->is_admin ? 'badge-primary badge-soft' : 'badge-soft' . ' badge-sm'" />
    @endscope

    <!-- Kolom account_type -->
    @scope('cell_account_type', $user)
    <x-badge :value="Str::title($user->account_type)" :class="$user->account_type == 'free' ? 'badge-soft' : 'badge-primary badge-soft' . ' badge-sm'" />
    @endscope

    <!-- Kolom premium_until -->
    @scope('cell_premium_until', $user)
    {{ $this->getPremiumStatus($user) }}
    @endscope

    <!-- Kolom tanggal daftar -->
    @scope('cell_created_at', $user)
    {{ $user->created_at->format('d M Y H:i') }}
    @endscope

    <!-- Kolom terakhir diubah -->
    @scope('cell_updated_at', $user)
    {{ $user->updated_at->format('d M Y H:i') }}
    @endscope

    <!-- Kolom aksi (edit profil) -->
    @scope('actions', $user)
    <div class="gap-1 flex">
      <x-button icon="lucide.edit" link="/admin/users/edit/{{ $user->username }}" class="btn-sm" />
      <x-button icon="lucide.trash" wire:click="confirmDelete({{ $user->id }})" spinner class="btn-sm" />
    </div>
    @endscope

    <!-- Tampilkan pesan jika data kosong -->
    <x-slot:empty>
      <div class="p-5">
        <x-icon name="lucide.inbox" label="It is empty." />
      </div>
    </x-slot:empty>
  </x-table>

  <!-- PIN Modal for Delete Confirmation -->
  <x-pin-modal wireModel="pinModal" pinModel="pin" title="Konfirmasi Hapus" description="Masukkan PIN untuk menghapus user ini." submitLabel="Hapus" submitAction="confirmPin" />
</div>
