<div>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-4 mb-4">

    <x-linked-stat title="Dana Darurat" :value="number_format($daruratSum)" icon="lucide.siren" :color="$daruratSumColor" class="bg-slate-200 dark:bg-slate-700 overflow-hidden" link="/auth/dana-darurat">

      <x-slot:description>
        <span class="font-bold text-sm">{{ number_format($daruratIdeal) }} (6 bulan)</span>
      </x-slot:description>

    </x-linked-stat>

    <x-linked-stat title="Dana Harian" :value="number_format($harianSum)" icon="lucide.wallet" :color="$harianSumColor" class="bg-slate-200 dark:bg-slate-700 overflow-hidden" link="/auth/dana-harian">

      <x-slot:description>
        <span class="font-bold text-sm">{{ number_format($harianAverage) }} (1 hari)</span>
      </x-slot:description>

    </x-linked-stat>

    <x-linked-stat title="Jumlah Investasi" :value="number_format($invesSum)" icon="lucide.vault" :color="$invesColor" class="bg-slate-200 dark:bg-slate-700 overflow-hidden" link="/auth/investasi">

      <x-slot:description>
        <span class="font-bold text-sm">{{ number_format($invesBtcSum, 8) }} BTC</span>
      </x-slot:description>

    </x-linked-stat>
    @if ($isStillPremium || $isFreeTrial)
    <!-- Premium & Free Trial User: tampil normal -->
    <x-stat title="Portofolio" :value="number_format($portoSum)" icon="lucide.pie-chart" class="{{ $portoColor }} bg-slate-200 dark:bg-slate-700 overflow-hidden" color="text-pink-500" :tooltip-bottom="$portoTooltip" wire:poll.300s='updateDashboard'>
      <x-slot:description>
        <span class="{{ $selColor }} font-bold text-sm">{{ number_format($selSum) }}</span>
        <span class="{{ $selColor }}">({{ number_format($persenSum, 2) }}%)</span>
      </x-slot:description>
    </x-stat>
    @else
    <!-- Non premium user: tampil blur -->
    <div class="relative group">
      <x-stat title="Portofolio" :value="number_format($portoSum)" icon="lucide.pie-chart" class="{{ $portoColor }} bg-slate-200 dark:bg-slate-700 overflow-hidden blur-xs lg:group-hover:blur-sm lg:transition lg:duration-300" color="text-pink-500" :tooltip-bottom="$portoTooltip" wire:poll.300s='updateDashboard'>
        <x-slot:description>
          <span class="{{ $selColor }} font-bold text-sm">{{ number_format($selSum) }}</span>
          <span class="{{ $selColor }}">({{ number_format($persenSum, 2) }}%)</span>
        </x-slot:description>
      </x-stat>

      <!-- Tombol muncul saat hover -->
      <x-button label="Upgrade" class="btn-primary btn-sm btn-soft absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 lg:opacity-0 lg:group-hover:opacity-100 lg:transition lg:duration-300" link="/auth/upgrade" no-wire-navigate />
    </div>
    @endif

  </div>

  <!-- Chart -->
  @if ($isStillPremium || $isFreeTrial)
  <!-- Premium & Free Trial User: tampil normal -->
  <div class="my-10 overflow-auto">
    <div class="min-w-[700px] sm:min-w-full h-[300px] sm:h-[400px] md:h-[500px]">
      <x-chart wire:poll.300s="updateDashboard" wire:model="myChart" class="h-full" />
    </div>
  </div>

  <!-- Header investasi -->
  <x-header title="Investasi" icon="lucide.vault" icon-classes="bg-warning rounded-full p-1 w-6 h-6" size="text-xl" separator />

  <!-- Tabel Investasi -->
  <x-table :headers="$headerInvestasis" :rows="$investasis" class="mb-10" link="/auth/investasi" striped>
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
  <x-table :headers="$headerDanaDarurats" :rows="$danaDarurats" class="mb-10" link="/auth/dana-darurat" striped>
    <!-- Table cell: ID -->
    @scope('cell_id', $danaDarurat)
    <strong>{{ $loop->iteration }}</strong>
    @endscope

    <!-- Table cell: Created At -->
    @scope('cell_created_at', $danaDarurat)
    {{ $danaDarurat->created_at->format('d M Y H:i') }}
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
  <x-table :headers="$headerDanaHarians" :rows="$danaHarians" link="/auth/dana-harian" striped>
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

    <!-- Empty State -->
    <x-slot:empty>
      <div class="p-5">
        <x-icon name="lucide.inbox" label="It is empty." />
      </div>
    </x-slot:empty>
  </x-table>

  @else

  <!-- Free user: tampil blur + overlay -->
  <div class="relative my-10 group overflow-auto">
    <div class="min-w-[700px] sm:min-w-full h-[300px] sm:h-[400px] md:h-[500px]">
      <x-chart wire:poll.300s="updateDashboard" wire:model="myChart" class="h-full blur-xs lg:group-hover:blur-sm lg:transition lg:duration-300" />
    </div>

    <!-- Tombol muncul saat hover -->
    <x-button label="Upgrade Premium 1.000/hari" class="btn-primary btn-sm btn-soft absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 lg:opacity-0 lg:group-hover:opacity-100 lg:transition lg:duration-300" link="/auth/upgrade" no-wire-navigate />
  </div>

  <div class="relative my-10 group overflow-auto">
    <div class="blur-xs lg:group-hover:blur-sm lg:transition lg:duration-300 px-4">
      <!-- Header investasi -->
      <x-header title="Investasi" icon="lucide.vault" icon-classes="bg-warning rounded-full p-1 w-6 h-6" size="text-xl" separator />

      <!-- Tabel Investasi -->
      <x-table :headers="$headerInvestasis" :rows="$investasis" class="mb-10" link="/auth/investasi" striped>
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
      <x-table :headers="$headerDanaDarurats" :rows="$danaDarurats" class="mb-10" link="/auth/dana-darurat" striped>
        <!-- Table cell: ID -->
        @scope('cell_id', $danaDarurat)
        <strong>{{ $loop->iteration }}</strong>
        @endscope

        <!-- Table cell: Created At -->
        @scope('cell_created_at', $danaDarurat)
        {{ $danaDarurat->created_at->format('d M Y H:i') }}
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
      <x-table :headers="$headerDanaHarians" :rows="$danaHarians" link="/auth/dana-harian" striped>
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

        <!-- Empty State -->
        <x-slot:empty>
          <div class="p-5">
            <x-icon name="lucide.inbox" label="It is empty." />
          </div>
        </x-slot:empty>
      </x-table>
    </div>

    <!-- Tombol muncul saat hover -->
    <x-button label="Upgrade Premium 1.000/hari" class="btn-primary btn-sm btn-soft absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 lg:opacity-0 lg:group-hover:opacity-100 lg:transition lg:duration-300" link="/auth/upgrade" no-wire-navigate />
  </div>
  @endif
</div>
