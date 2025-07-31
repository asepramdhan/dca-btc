<div>
  <x-header>
    <x-slot:middle class="!justify-end">
      <x-input icon="lucide.search" placeholder="Cari Tanggal, Pemilik, Kode Voucher dan Status . . ." wire:model.live='search' />
    </x-slot:middle>
    <x-slot:actions>
      <x-button icon="lucide.plus" class="btn-sm btn-ghost" link="/admin/voucher/tambah-voucher" />
    </x-slot:actions>
  </x-header>
  <!-- Tabel data user -->
  <x-table :headers="$headers" :rows="$vouchers" striped with-pagination>
    <!-- Kolom nomor urut -->
    @scope('cell_id', $voucher)
    <strong>{{ $loop->iteration }}</strong>
    @endscope

    <!-- Kolom tanggal -->
    @scope('cell_created_at', $voucher)
    {{ $voucher->created_at->format('d M Y H:i') }}
    @endscope

    <!-- Kolom user name -->
    @scope('cell_user.name', $voucher)
    {{ Str::title($voucher->user->name) }}
    @endscope

    <!-- Kolom paket -->
    @scope('cell_package.name', $voucher)
    {{ Str::title($voucher->package->name) }}
    @endscope

    <!-- Kolom status -->
    @scope('cell_is_active', $voucher)
    <x-badge :value="$voucher->is_active == 1 ? 'Tersedia' : 'Digunakan'" :class="$voucher->is_active == 1 ? 'badge-soft' : 'badge-primary badge-soft' . ' badge-sm'" />
    @endscope

    <!-- Kolom terakhir diubah -->
    @scope('cell_updated_at', $voucher)
    {{ $voucher->updated_at->format('d M Y H:i') }}
    @endscope

    <!-- Kolom aksi (edit paket) -->
    @scope('actions', $voucher)
    <div class="gap-1 flex">
      <x-button icon="lucide.edit" link="/admin/voucher/edit/{{ $voucher->code }}" class="btn-sm" />
      <x-button icon="lucide.trash" wire:click="confirmDelete({{ $voucher->id }})" spinner class="btn-sm" />
    </div>
    @endscope

    <!-- Tampilkan pesan jika data kosong -->
    <x-slot:empty>
      <div class="p-5">
        <x-icon name="lucide.inbox" label="Belum ada voucher." />
      </div>
    </x-slot:empty>
  </x-table>

  <!-- PIN Modal for Delete Confirmation -->
  <x-pin-modal wireModel="pinModal" pinModel="pin" title="Konfirmasi Hapus" description="Masukkan PIN untuk menonaktifkan paket ini." submitLabel="Hapus" submitAction="confirmPin" />
</div>
