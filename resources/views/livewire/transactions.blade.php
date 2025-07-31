<div wire:poll.900s="checkExpiredTransactions">
  <div x-data="{
    isPaying: false,
    init() {
        // ✅ Dengarkan event dari Livewire dan log ke console
        window.addEventListener('console-log', (e) => {
            console.log('📦 [Livewire Log]', e.detail?.message ?? e.detail);
        });

        // Event Snap token diterima
        $wire.$on('snap-token-received', ({ token }) => {
            if (!token) {
                console.error('❌ Token tidak diterima');
                return;
            }

            if (this.isPaying) {
                console.log('⚠️ Masih dalam proses pembayaran...');
                return;
            }

            this.isPaying = true;

            snap.pay(token, {
                onSuccess: (result) => {
                    console.log('✅ Success', result);
                    this.isPaying = false;

                    // Kirim ke Livewire
                    $wire.handlePayment(result);
                },
                onPending: (result) => {
                    console.log('🕒 Pending', result);
                    this.isPaying = false;

                    // Kirim ke Livewire
                    $wire.handlePayment(result);
                },
                onError: (result) => {
                    console.error('❌ Error', result);
                    this.isPaying = false;
                },
                onClose: () => {
                    console.log('❌ Popup ditutup oleh user');
                    this.isPaying = false;
                },
            });
        });
    }
}" x-init="init">
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
        <x-button label="Lanjutkan Pembayaran" icon="lucide.qr-code" class="btn-sm btn-warning" wire:click="lanjutBayar({{ $transaction->id }})" spinner />
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
  </div>
</div>
