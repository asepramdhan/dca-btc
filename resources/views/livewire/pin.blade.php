<div>
  <!-- Table Section -->
  <x-table :headers="$headers" :rows="$pins" striped>
    <!-- Nama Lengkap Column -->
    @scope('cell_name', $pin)
    {{ Str::upper($pin->name) }}
    @endscope

    <!-- PIN Column -->
    @scope('cell_pin', $pin)
    <x-badge :value="$pin->pin ? '****' : 'Belum Diatur'" :class="$pin->pin ? 'badge-success badge-sm' : 'badge-error badge-sm'" />
    @endscope

    <!-- Updated At Column -->
    @scope('cell_updated_at', $pin)
    {{ $pin->updated_at->format('d M Y H:i') }}
    @endscope

    <!-- Actions Column -->
    @scope('actions', $pin)
    <div class="flex justify-end gap-1">
      <x-button label="{{ $pin->pin ? 'Ubah PIN' : 'Buat PIN' }}" icon="lucide.key" class="btn-sm" wire:click="createPin({{ $pin->id }})" />
      <x-button icon="lucide.trash" wire:click="confirmDelete({{ $pin->id }})" spinner class="btn-sm" />
    </div>
    @endscope

    <!-- Empty State -->
    <x-slot:empty>
      <div class="p-5">
        <x-icon name="lucide.inbox" label="It is empty." />
      </div>
    </x-slot:empty>
  </x-table>

  <!-- Modal for Creating/Updating PIN -->
  <x-buat-pin-modal wireModel="pinModal" pinModel="pin" title="Buat PIN" description="Masukkan 4 digit PIN" submitLabel="Simpan" submitAction="storePin" />
  <!-- Delete Confirmation Modal -->
  <x-konfirmasi-modal wireModel="deleteModal" title="Konfirmasi" description="Apakah kamu yakin ingin menghapus data ini?" submitLabel="Hapus" submitAction="deleteConfirmed" />
</div>
