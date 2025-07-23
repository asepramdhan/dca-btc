<div>
  <x-header>
    <x-slot:middle class="!justify-end">
      <x-input icon="o-bolt" placeholder="Cari Keterangan..." />
    </x-slot:middle>
    <x-slot:actions>
      <x-button icon="o-plus" class="btn-sm btn-ghost" :link="route('tambah-dana-darurat')" />
    </x-slot:actions>
  </x-header>

  <!-- Dana Darurat Table -->
  <x-table :headers="$headers" :rows="$danaDarurats" striped with-pagination>
    <!-- Table cell: ID -->
    @scope('cell_id', $danaDarurat)
    <strong>{{ $loop->iteration }}</strong>
    @endscope

    <!-- Table cell: Created At -->
    @scope('cell_created_at', $danaDarurat)
    {{ $danaDarurat->created_at->format('d M Y') }}
    @endscope

    <!-- Table cell: Amount -->
    @scope('cell_amount', $danaDarurat)
    @if ($danaDarurat->type === 'pengeluaran')
    <strong class="text-error">-{{ number_format($danaDarurat->amount) }}</strong>
    @else
    <strong>{{ number_format($danaDarurat->amount) }}</strong>
    @endif
    @endscope

    <!-- Table cell: Type -->
    @scope('cell_type', $danaDarurat)
    <x-badge value="{{ Str::title($danaDarurat->type) }}" class="badge-dash {{ $danaDarurat->type === 'pemasukan' ? 'badge-success' : 'badge-error' }}" />
    @endscope

    <!-- Table cell: Description -->
    @scope('cell_description', $danaDarurat)
    {{ Str::ucfirst($danaDarurat->description) }}
    @endscope

    <!-- Table cell: Actions -->
    @scope('actions', $danaDarurat)
    <div class="flex gap-1">
      <x-button icon="lucide.edit" link="/auth/dana-darurat/edit/{{ $danaDarurat->id }}" class="btn-sm" />
      <x-button icon="lucide.trash" wire:click="confirmDelete({{ $danaDarurat->id }})" spinner class="btn-sm" />
    </div>
    @endscope

    <x-slot:footer class="bg-base-200 text-right">
      <tr>
        <td colspan="6">Total Dana Darurat : {{ number_format($daruratSum) }}</td>
      </tr>
    </x-slot:footer>

    <!-- Empty State -->
    <x-slot:empty>
      <div class="p-5">
        <x-icon name="lucide.inbox" label="It is empty." />
      </div>
    </x-slot:empty>
  </x-table>

  <!-- Edit Modal -->
  {{-- <x-edit-dana-modal wireModel="editModal" submitAction="saveEdit" :types="$types" /> --}}
  <!-- Delete Confirmation Modal -->
  <x-konfirmasi-modal wireModel="deleteModal" title="Konfirmasi" description="Apakah kamu yakin ingin menghapus data ini?" submitLabel="Hapus" submitAction="deleteConfirmed" />
</div>
