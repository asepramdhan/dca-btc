<div>
  @props([
  'wireModel' => 'selectPaymentModal',
  'paymentModel' => 'payment',
  'title' => 'Konfirmasi Pembayaran',
  'description' => 'Scan QR Code untuk melakukan pembayaran!',
  'expiryTimestamp' => null, // Terima timestamp dari Livewire
  'submitLabel' => 'Sudah Bayar',
  'cancelLabel' => 'Batal',
  'submitAction' => 'confirmPayment',
  'cancelAction' => 'cancelPayment',
  'image' => '',
  ])

  <x-modal :wire:model="$wireModel" class="backdrop-blur" box-class="w-64" persistent separator>
    <x-form wire:submit="{{ $submitAction }}">
      {{-- Bagian untuk menampilkan hitung mundur --}}
      <span class="text-sm font-semibold text-center" x-data="{
                    remainingTime: '00:00:00',
                    interval: null,

                    // Fungsi pembantu untuk memformat waktu
                    formatTime(distance) {
                        if (distance < 0) {
                            return '00:00:00';
                        }
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        return String(hours).padStart(2, '0') + ':' +
                               String(minutes).padStart(2, '0') + ':' +
                               String(seconds).padStart(2, '0');
                    },

                    startCountdown() {
                        if (this.interval) clearInterval(this.interval); // Bersihkan interval sebelumnya

                        // Pastikan timestamp valid sebelum memulai
                        if (!this.$wire.expiryTimestamp) {
                            this.remainingTime = '00:00:00';
                            return;
                        }

                        const targetTime = this.$wire.expiryTimestamp * 1000; // Konversi ke milidetik

                        // Perbarui waktu segera setelah memulai
                        const initialNow = new Date().getTime();
                        this.remainingTime = this.formatTime(targetTime - initialNow);

                        this.interval = setInterval(() => {
                            const now = new Date().getTime();
                            const distance = targetTime - now;

                            if (distance < 0) {
                                clearInterval(this.interval);
                                this.remainingTime = '00:00:00';
                                // Opsional: Beritahu Livewire bahwa waktu habis
                                // this.$wire.call('timeExpired');
                                return;
                            }
                            this.remainingTime = this.formatTime(distance);
                        }, 1000); // Perbarui setiap 1 detik
                    },

                    init() {
                        // Gunakan $watch untuk memantau perubahan pada properti Livewire
                        this.$watch('$wire.expiryTimestamp', (newTimestamp) => {
                            console.log('expiryTimestamp changed:', newTimestamp); // Untuk debugging
                            if (newTimestamp) {
                                this.startCountdown();
                            } else {
                                clearInterval(this.interval);
                                this.remainingTime = '00:00:00';
                            }
                        });

                        // Juga periksa saat inisialisasi awal, mungkin timestamp sudah ada
                        if (this.$wire.expiryTimestamp) {
                            this.startCountdown();
                        }
                    },
                }" x-text="remainingTime">
        00:00:00
      </span>
      <img src="{{ asset($image) }}" alt="{{ $title }}">
      <span class="text-sm font-semibold text-center">{{ $description }}</span>
      <div x-data="{ open: false }" class="mt-4">
        <span x-on:click="open = ! open" class="cursor-pointer text-sm font-semibold text-primary">
          Cara Pembayaran
          <template x-if="open">
            <x-icon name="lucide.chevron-up" />
          </template>
          <template x-if="!open">
            <x-icon name="lucide.chevron-down" />
          </template>
        </span>

        <div x-show="open">
          {{ $slot }}
        </div>
      </div>

      <x-slot:actions>
        <x-button label="{{ $cancelLabel }}" wire:click="{{ $cancelAction }}" />
        <x-button label="{{ $submitLabel }}" class="btn-primary" type="submit" spinner="{{ $submitAction }}" />
      </x-slot:actions>
    </x-form>
  </x-modal>
</div>
