<div>
  <x-header>
    <x-slot:middle class="!justify-end">
      <x-input icon="lucide.search" placeholder="Cari Nama, Username, E-mail, Role, Tipe akun, Tanggal daftar, Terakhir diubah . . ." />
    </x-slot:middle>
    <x-slot:actions>
      <x-button icon="lucide.plus" class="btn-sm btn-ghost" link="/admin/paket/tambah-paket" />
    </x-slot:actions>
  </x-header>
  <!-- Tabel data user -->
  <x-table :headers="$headers" :rows="$pakets" striped with-pagination>
    <!-- Kolom nomor urut -->
    @scope('cell_id', $paket)
    <strong>{{ $loop->iteration }}</strong>
    @endscope

    <!-- Kolom nama paket -->
    @scope('cell_name', $paket)
    {{ Str::title($paket->name) }}
    @endscope

    <!-- Kolom harga -->
    @scope('cell_price', $paket)
    {{ number_format($paket->price) }}
    @endscope

    <!-- Kolom status -->
    @scope('cell_is_active', $paket)
    <x-badge :value="$paket->is_active == 1 ? 'Aktif' : 'Tidak Aktif'" :class="$paket->is_active == 1 ? 'badge-primary badge-soft' : 'badge-soft' . ' badge-sm'" />
    @endscope

    <!-- Kolom tanggal daftar -->
    @scope('cell_created_at', $paket)
    {{ $paket->created_at->format('d M Y H:i') }}
    @endscope

    <!-- Kolom terakhir diubah -->
    @scope('cell_updated_at', $paket)
    {{ $paket->updated_at->format('d M Y H:i') }}
    @endscope

    <!-- Kolom aksi (edit paket) -->
    @scope('actions', $paket)
    <div class="gap-1 flex">
      <x-button icon="lucide.edit" link="/admin/paket/edit/{{ $paket->id }}" class="btn-sm" />
      <x-button icon="lucide.trash" wire:click="confirmDelete({{ $paket->id }})" spinner class="btn-sm" />
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
  <x-pin-modal wireModel="pinModal" pinModel="pin" title="Konfirmasi Hapus" description="Masukkan PIN untuk menonaktifkan paket ini." submitLabel="Hapus" submitAction="confirmPin" />
</div>
