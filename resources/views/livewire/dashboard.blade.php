<div>
  <div class="grid grid-cols-2 md:grid-cols-4 grid-rows-2 md:grid-rows-1 gap-4 mb-4">

    <x-linked-stat title="Dana Darurat" :value="number_format($daruratSum)" icon="lucide.siren" :color="$daruratSumColor" class="bg-slate-200 " :link="route('dana-darurat')">

      <x-slot:description>
        <span class="font-bold text-sm">{{ number_format($daruratIdeal) }} (6 bulan)</span>
      </x-slot:description>

    </x-linked-stat>

    <x-linked-stat title="Dana Harian" :value="number_format($harianSum)" icon="lucide.wallet" :color="$harianSumColor" class="bg-slate-200" :link="route('dana-harian')">

      <x-slot:description>
        <span class="font-bold text-sm">{{ number_format($harianAverage) }} (1 hari)</span>
      </x-slot:description>

    </x-linked-stat>

    <x-linked-stat title="Jumlah Investasi" :value="number_format($invesSum)" icon="lucide.vault" :color="$invesColor" class="bg-slate-200" :link="route('investasi')">

      <x-slot:description>
        <span class="font-bold text-sm">{{ number_format($invesBtcSum, 8) }} BTC</span>
      </x-slot:description>

    </x-linked-stat>

    <x-stat title="Portofolio" :value="number_format($portoSum)" icon="lucide.pie-chart" class="{{ $portoColor }} bg-slate-200" color="text-pink-500" :tooltip-bottom="$portoTooltip" wire:poll.300s='updateDashboard'>

      <x-slot:description>
        <span class="{{ $selColor }} font-bold text-sm">{{ number_format($selSum) }}</span>
        <span class="{{ $selColor }}">({{ number_format($persenSum, 2) }}%)</span>
      </x-slot:description>

    </x-stat>

  </div>

  <!-- Chart -->
  <div class="my-10 w-full overflow-x-auto">
    <div class="min-w-[700px] sm:min-w-full h-[300px] sm:h-[400px] md:h-[500px]">
      <x-chart wire:poll.300s="updateDashboard" wire:model="myChart" class="h-full" />
    </div>
  </div>

  <!-- Header investasi -->
  <x-header title="Investasi" icon="lucide.vault" icon-classes="bg-warning rounded-full p-1 w-6 h-6" size="text-xl" separator />

  <!-- Tabel Investasi -->
  <x-table :headers="$headerInvestasis" :rows="$investasis" class="mb-10" :link="route('investasi')" striped>
    <!-- Kolom: No -->
    @scope('cell_id', $investasi)
    <strong>{{ $loop->iteration }}</strong>
    @endscope

    <!-- Kolom: Tanggal -->
    @scope('cell_created_at', $investasi)
    {{ $investasi->created_at->format('d M Y') }}
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

    <!-- Jika data kosong -->
    <x-slot:empty>
      <div class="p-5">
        <x-icon name="lucide.inbox" label="It is empty." />
      </div>
    </x-slot:empty>
  </x-table>

  <!-- Header dana darurat -->
  <x-header title="Dana Darurat" icon="lucide.siren" icon-classes="bg-warning rounded-full p-1 w-6 h-6" size="text-xl" separator />

  <!-- Dana Darurat Table -->
  <x-table :headers="$headerDanaDarurats" :rows="$danaDarurats" class="mb-10" :link="route('dana-darurat')" striped>
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

    <!-- Empty State -->
    <x-slot:empty>
      <div class="p-5">
        <x-icon name="lucide.inbox" label="It is empty." />
      </div>
    </x-slot:empty>
  </x-table>

  <!-- Header dana harian -->
  <x-header title="Dana Harian" icon="lucide.wallet" icon-classes="bg-warning rounded-full p-1 w-6 h-6" size="text-xl" separator />

  <!-- Dana harian Table -->
  <x-table :headers="$headerDanaHarians" :rows="$danaHarians" :link="route('dana-harian')" striped>
    <!-- Row Number -->
    @scope('cell_id', $danaHarian)
    <strong>{{ $loop->iteration }}</strong>
    @endscope

    <!-- Date -->
    @scope('cell_created_at', $danaHarian)
    {{ $danaHarian->created_at->format('d M Y') }}
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

    <!-- Empty State -->
    <x-slot:empty>
      <div class="p-5">
        <x-icon name="lucide.inbox" label="It is empty." />
      </div>
    </x-slot:empty>
  </x-table>
</div>
