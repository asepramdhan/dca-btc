<div>
  <x-header>
    <x-slot:middle class="!justify-end">
      <x-input icon="lucide.search" placeholder="Cari Tanggal dan Tipe Pembayaran . . ." wire:model.live='search' />
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
            'Failed' => 'badge-destructive badge-soft',
            'Expired' => 'badge-muted badge-soft', // Ini akan digunakan untuk status 'expire'
            default => 'badge-muted badge-soft',
        }" />
    @endscope

    @scope('cell_amount', $transaction)
    Rp{{ number_format($transaction->amount, 0, ',', '.') }}
    @endscope

    @scope('actions', $transaction)
    @if ($transaction->status === 'pending')
    <div class="gap-1 flex">
      <x-button icon="lucide.qr-code" class="btn-sm btn-warning" tooltip-left="Lanjutkan Pembayaran" wire:click="lanjutBayar({{ $transaction->id }})" spinner />
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

  <!-- Modal for Select Payment -->
  <x-select-payment-modal wireModel="selectPaymentModal" :expiryTimestamp="$expiryTimestamp" submitAction="confirmPayment" :image="$QRCode" :description="$descriptionText">
    {{ $howPayment }}
  </x-select-payment-modal>
</div>
