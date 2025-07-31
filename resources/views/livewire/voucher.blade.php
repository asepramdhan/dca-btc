<div>
  <x-header>
    <x-slot:middle class="!justify-end">
      <x-input icon="lucide.search" placeholder="Cari Tanggal dan Status . . ." wire:model.live='search' />
    </x-slot:middle>
  </x-header>
  <x-table :headers="$headers" :rows="$vouchers" striped with-pagination>
    @scope('cell_id', $voucher)
    <strong>{{ $loop->iteration }}</strong>
    @endscope

    @scope('cell_created_at', $voucher)
    {{ $voucher->created_at->format('d M Y H:i') }}
    @endscope

    @scope('cell_package.name', $voucher)
    {{ Str::title($voucher->package->name) }}
    @endscope

    @scope('cell_is_active', $voucher)
    <x-badge :value="$voucher->is_active == 1 ? 'Tersedia' : 'Digunakan'" :class="$voucher->is_active == 1 ? 'badge-soft' : 'badge-primary badge-soft' . ' badge-sm'" />
    @endscope

    @scope('actions', $voucher)
    @if ($voucher->is_active)
    <x-button icon="lucide.ticket" wire:click="viewVoucher({{ $voucher->id }})" spinner class="btn-sm" />
    @endif
    @endscope

    <x-slot:empty>
      <div class="p-5">
        <x-icon name="lucide.inbox" label="Belum ada voucher." />
      </div>
    </x-slot:empty>
  </x-table>

  <x-modal wire:model="voucherModal" class="backdrop-blur">
    <div x-data="{
            copied: false,
            // Hapus 'copyText' di sini karena kita akan langsung mengambilnya dari $wire
            copyToClipboard() {
                // Gunakan $wire.currentVoucherCode untuk mendapatkan nilai terbaru dari Livewire
                const textToCopy = $wire.currentVoucherCode; 

                navigator.clipboard.writeText(textToCopy)
                    .then(() => {
                        this.copied = true;
                        setTimeout(() => this.copied = false, 3000);
                    })
                    .catch(err => {
                        console.error('Gagal menyalin:', err);
                        // Fallback untuk browser lama atau jika API gagal
                        const textArea = document.createElement('textarea');
                        textArea.value = textToCopy; // Pastikan menggunakan textToCopy
                        textArea.style.position = 'fixed';
                        document.body.appendChild(textArea);
                        textArea.focus();
                        textArea.select();
                        try {
                            document.execCommand('copy');
                            this.copied = true;
                            setTimeout(() => this.copied = false, 3000);
                        } catch (err) {
                            console.error('Fallback copy gagal:', err);
                        }
                        document.body.removeChild(textArea);
                    });
            }
        }" {{-- Hapus x-init yang watch voucherModal --}} class="flex flex-col items-center justify-center h-[200px] sm:h-[250px] md:h-[300px] p-4">

      <h1 id="voucherCode" class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-primary text-center tracking-widest cursor-pointer hover:underline" title="Klik untuk menyalin" @click="copyToClipboard()">
        {{ $currentVoucherCode }}
      </h1>
      <p class="text-sm text-gray-500 mt-2">Salin kode ini untuk digunakan!</p>

      <x-button label="Salin Kode" icon="lucide.copy" class="btn-primary mt-4" @click="copyToClipboard()" />

      <span x-show="copied" x-transition.opacity.duration.300ms class="text-sm text-success mt-2">
        Kode berhasil disalin!
      </span>
    </div>
  </x-modal>
</div>
