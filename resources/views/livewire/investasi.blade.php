<div>
  <x-header>
    <x-slot:middle class="!justify-end">
      <x-input icon="lucide.search" placeholder="Cari Tanggal, Bulan, Tahun, Jam, Tipe dan Keterangan . . ." wire:model.live='search' />
    </x-slot:middle>
    <x-slot:actions>
      <x-button icon="lucide.circle-fading-plus" class="btn-sm btn-ghost" :link="route('tambah-investasi')" />
    </x-slot:actions>
  </x-header>

  <x-table :headers="$headers" :rows="$investasis" striped with-pagination>
    <!-- Kolom: No -->
    @scope('cell_id', $investasi)
    <strong>{{ $loop->iteration }}</strong>
    @endscope

    <!-- Kolom: Tanggal -->
    @scope('cell_created_at', $investasi)
    {{ $investasi->created_at->format('d M Y H:i') }}
    @endscope

    <!-- Kolom: Jumlah (Rp) -->
    @scope('cell_amount', $investasi)
    @if($investasi->type == 'jual')
    <strong class="text-error">-{{ number_format($investasi->amount) }}</strong>
    @else
    <strong>{{ number_format($investasi->amount) }}</strong>
    @endif
    @endscope

    <!-- Kolom: Harga Beli/Jual -->
    @scope('cell_price', $investasi)
    {{ number_format($investasi->price) }}
    @endscope

    <!-- Kolom: Fee -->
    @scope('cell_fee', $investasi)
    {{ $investasi->type == 'beli' ? $investasi->exchange->fee_buy : $investasi->exchange->fee_sell }}
    @endscope

    <!-- Kolom: Jumlah BTC -->
    @scope('cell_quantity', $investasi)
    @if($investasi->type == 'jual')
    <strong class="text-error">-{{ number_format($investasi->quantity, 8) }}</strong>
    @else
    <strong>{{ number_format($investasi->quantity, 8) }}</strong>
    @endif
    @endscope

    <!-- Kolom: Exchange -->
    @scope('cell_exchange_id', $investasi)
    {{ Str::upper($investasi->exchange->name) }}
    @endscope

    <!-- Kolom: Tipe -->
    @scope('cell_type', $investasi)
    <x-badge value="{{ Str::title($investasi->type) }}" class="badge-{{ $investasi->type == 'beli' ? 'success' : 'error' }} badge-dash" />
    @endscope

    <!-- Kolom: Keterangan -->
    @scope('cell_description', $investasi)
    {{ Str::ucfirst($investasi->description) }}
    @endscope

    <!-- Aksi -->
    @scope('actions', $investasi)
    <div class="flex gap-1">
      <x-button icon="lucide.edit" link="/auth/investasi/edit/{{ $investasi->id }}" class="btn-sm" />
      <x-button icon="lucide.trash" wire:click="confirmDelete({{ $investasi->id }})" spinner class="btn-sm" />
    </div>
    @endscope

    <x-slot:footer class="bg-base-200 text-right">
      <tr>
        <td colspan="10">Total Investasi :
          {{ number_format($invesSum) }}
        </td>
      </tr>
    </x-slot:footer>

    <!-- Jika data kosong -->
    <x-slot:empty>
      <div class="p-5">
        <x-icon name="lucide.inbox" label="It is empty." />
      </div>
    </x-slot:empty>
  </x-table>

  <!-- Delete Confirmation Modal -->
  <x-konfirmasi-modal wireModel="deleteModal" title="Konfirmasi" description="Apakah kamu yakin ingin menghapus data ini?" submitLabel="Hapus" submitAction="deleteConfirmed" />
</div>
