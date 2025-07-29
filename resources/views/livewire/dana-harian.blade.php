<div>
  <x-header>
    <x-slot:middle class="!justify-end">
      <x-input icon="lucide.search" placeholder="Cari Tanggal, Bulan, Tahun, Jam, Tipe dan Keterangan . . ." wire:model.live='search' />
    </x-slot:middle>
    <x-slot:actions>
      <x-button icon="lucide.plus" class="btn-sm btn-ghost" link="/auth/dana-harian/tambah-dana-harian" />
    </x-slot:actions>
  </x-header>

  <!-- Dana harian Table -->
  <x-table :headers="$headers" :rows="$danaHarians" striped with-pagination>
    <!-- Row Number -->
    @scope('cell_id', $danaHarian)
    <strong>{{ $loop->iteration }}</strong>
    @endscope

    <!-- Date -->
    @scope('cell_created_at', $danaHarian)
    {{ $danaHarian->created_at->format('d M Y H:i') }}
    @endscope

    <!-- Amount -->
    @scope('cell_amount', $danaHarian)
    @if ($danaHarian->type == 'pengeluaran')
    <strong class="text-error">-{{ number_format($danaHarian->amount) }}</strong>
    @else
    <strong>{{ number_format($danaHarian->amount) }}</strong>
    @endif
    @endscope

    <!-- Type -->
    @scope('cell_type', $danaHarian)
    <x-badge value="{{ Str::title($danaHarian->type) }}" class="{{ $danaHarian->type == 'pemasukan' ? 'badge-success' : 'badge-error' }} badge-dash" />
    @endscope

    <!-- Description -->
    @scope('cell_description', $danaHarian)
    {{ Str::ucfirst($danaHarian->description) }}
    @endscope

    <!-- Action Buttons -->
    @scope('actions', $danaHarian)
    <div class="flex gap-1">
      <x-button icon="lucide.edit" link="/auth/dana-harian/edit/{{ $danaHarian->id }}" class="btn-sm" />
      <x-button icon="lucide.trash" wire:click="confirmDelete({{ $danaHarian->id }})" spinner class="btn-sm" />
    </div>
    @endscope

    <x-slot:footer class="bg-base-200 text-right">
      <tr>
        <td colspan="6">Total Dana Harian :
          {{ number_format($harianSum) }}
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

  <!-- Delete Confirmation Modal -->
  <x-konfirmasi-modal wireModel="deleteModal" title="Konfirmasi" description="Apakah kamu yakin ingin menghapus data ini?" submitLabel="Hapus" submitAction="deleteConfirmed" />
</div>
