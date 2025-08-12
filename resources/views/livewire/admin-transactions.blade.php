<div>
  <x-header>
    <x-slot:middle class="!justify-end">
      <x-input icon="lucide.search" placeholder="Cari Tanggal, Nama User, ID Pesanan dan Tipe Pembayaran . . ." wire:model.live='search' />
    </x-slot:middle>
  </x-header>
  <!-- Tabel data user -->
  <x-table :headers="$headers" :rows="$transactions" striped with-pagination>

    @scope('cell_id', $transaction)
    <strong>{{ $loop->iteration }}</strong>
    @endscope

    @scope('cell_created_at', $transaction)
    {{ $transaction->created_at->format('d M Y H:i') }}
    @endscope

    @scope('cell_user.name', $transaction)
    {{ Str::title($transaction->user->name) ?? '-' }}
    @endscope

    @scope('cell_package.name', $transaction)
    {{ Str::title($transaction->package->name) ?? '-' }}
    @endscope

    @scope('cell_order_id', $transaction)
    {{ $transaction->order_id }}
    @endscope

    @scope('cell_payment_type', $transaction)
    {{ Str::upper($transaction->payment_type ?? '-') }}
    @endscope

    @scope('cell_status', $transaction)
    <x-badge :value="$transaction->status_label" :class="match($transaction->status_label) {
            'Success' => 'badge-success badge-soft',
            'Pending' => 'badge-warning badge-soft',
            'Processing' => 'badge-info badge-soft',
            'Failed' => 'badge-error badge-soft',
            default => 'badge-muted badge-soft',
        }" />
    @endscope

    @scope('cell_amount', $transaction)
    Rp{{ number_format($transaction->amount, 0, ',', '.') }}
    @endscope

    @scope('actions', $transaction)
    @if ($transaction->status === 'process')
    <div class="gap-1 flex">
      <x-button icon="lucide.check" class="btn-sm btn-accent btn-outline" wire:click="paymentCheck({{ $transaction->id }})" spinner />
    </div>
    @endif
    @endscope

    <!-- Jika data kosong -->
    <x-slot:empty>
      <div class="p-5 text-center text-muted">
        <x-icon name="lucide.inbox" class="mx-auto mb-2" />
        <div>Belum ada transaksi ditemukan.</div>
      </div>
    </x-slot:empty>
  </x-table>

  <!-- Drawer for Payment Check -->
  <x-payment-check-drawer wireModel="paymentCheckDrawer" paymentModel="payment" submitAction="confirmPayment" rejectAction="rejectPayment" :title="'Cek Pembayaran : ' . Str::title($userName)" :item="$transaction">
    <div class="font-semibold">Tanggal</div>
    <div>: {{ $tanggal }}</div>

    <div class="font-semibold">ID Transaksi</div>
    <div>: {{ $idTransaksi }}</div>

    <div class="font-semibold">Nominal</div>
    <div>: {{ $nominal }}</div>

    <div class="font-semibold">Tipe Pembayaran</div>
    <div>: {{ Str::upper($tipePembayaran) }}</div>

    <div class="font-semibold">Status</div>
    <div>: {{ Str::title($status) }}</div>

    <div class="font-semibold">Keterangan</div>
    <div>: {{ Str::title($keterangan) }}</div>
  </x-payment-check-drawer>
</div>
