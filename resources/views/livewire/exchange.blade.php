<div>
  <x-header>
    <x-slot:middle class="!justify-end">
      <x-input icon="lucide.search" placeholder="Cari Tanggal, Bulan, Tahun, Jam dan Exchange . . ." wire:model.live='search' />
    </x-slot:middle>
    <x-slot:actions>
      <x-button icon="lucide.plus" class="btn-sm btn-ghost" link="/auth/exchange/tambah-exchange" />
    </x-slot:actions>
  </x-header>

  <!-- Dana harian Table -->
  <x-table :headers="$headers" :rows="$exchanges" striped with-pagination>
    <!-- Row Number -->
    @scope('cell_id', $exchange)
    <strong>{{ $loop->iteration }}</strong>
    @endscope
    <!-- Date -->
    @scope('cell_created_at', $exchange)
    {{ $exchange->created_at->format('d M Y H:i') }}
    @endscope
    <!-- Custom cell for Exchange Name (uppercase) -->
    @scope('cell_name', $exchange)
    {{ Str::upper($exchange->name) }}
    @endscope
    <!-- Custom cell for User (Admin or user name) -->
    @scope('cell_user_id', $exchange)
    <span class="{{ $exchange->user_id != auth()->id() ? 'text-slate-300' : '' }}">
      {{ $exchange->user->is_admin ? 'Admin' : Str::title($exchange->user->name) }}
    </span>
    @endscope
    <!-- Action Buttons -->
    @scope('actions', $exchange)
    <div class="gap-1 {{ $exchange->user_id != auth()->id() ? 'hidden' : 'flex' }}">
      <x-button icon="lucide.edit" link="/auth/exchange/edit/{{ $exchange->id }}" class="btn-sm" />
      <x-button icon="lucide.trash" wire:click="confirmDelete({{ $exchange->id }})" spinner class="btn-sm" />
    </div>
    @endscope

    <x-slot:footer class="bg-base-200 text-right">
      <tr>
        <td colspan="7">Total Exchange : {{ $exchanges->count() }}
        </td>
      </tr>
    </x-slot:footer>

    <!-- Empty State -->
    <x-slot:empty>
      <div class="p-5">
        <x-icon name="lucide.inbox" label="It is empty." />
      </div>
    </x-slot:empty>
  </x-table>

  <!-- PIN Modal for Delete Confirmation -->
  <x-pin-modal wireModel="pinModal" pinModel="pin" title="Konfirmasi Hapus" description="Masukkan PIN untuk menghapus exchange ini." submitLabel="Hapus" submitAction="confirmPin" />
</div>
