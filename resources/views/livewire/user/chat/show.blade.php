<div>
  <x-header title="Chat dengan Admin" subtitle="Hubungi tim dukungan kami." separator />

  <x-alert icon="lucide.alert-triangle" class="alert-info mb-4">
    Fitur <strong><i>Chat</i></strong> masih dalam tahap pengembangan.
  </x-alert>

  <div class="flex flex-col h-[70vh] bg-base-100 rounded-lg shadow-xl overflow-hidden" x-data="{
        isAtBottom: true,
        autoScrollTimeout: null,
        previousScrollHeight: 0, // Untuk menyimpan tinggi scroll sebelum update
        isInitialLoad: true, // Flag untuk scroll awal

        init() {
            // Scroll ke bawah saat pertama kali inisialisasi
            // Gunakan nextTick untuk memastikan DOM sudah dirender
            this.$nextTick(() => {
                this.scrollToBottom();
                this.isInitialLoad = false; // Setelah scroll awal, matikan flag
            });

            // Listener untuk event scroll di messagesDiv
            this.$refs.messagesDiv.addEventListener('scroll', () => {
                clearTimeout(this.autoScrollTimeout); // Debounce scroll event
                this.autoScrollTimeout = setTimeout(() => {
                    this.updateScrollState();
                    this.checkScrollTopForLoadMore(); // Cek apakah perlu load lebih
                }, 100);
            });

            // Livewire event saat ada pesan baru (dari poll atau kirim pesan)
            Livewire.on('messagesUpdated', () => {
                if (this.isAtBottom) { // Jika user di paling bawah, scroll ke pesan baru
                    this.$nextTick(() => this.scrollToBottom());
                } else if (!this.isInitialLoad) {
                    // Jika ada pesan baru dari polling/kirim tapi user sedang scroll ke atas,
                    // jangan ganggu posisi scroll. Biarkan mereka tetap di tempatnya.
                }
            });

            // Livewire event saat pesan lama dimuat (`loadMore()`)
            Livewire.on('messagesLoaded', () => {
                this.$nextTick(() => {
                    // Pulihkan posisi scroll setelah pesan lama ditambahkan
                    const currentScrollHeight = this.$refs.messagesDiv.scrollHeight;
                    const scrollDifference = currentScrollHeight - this.previousScrollHeight;
                    this.$refs.messagesDiv.scrollTop += scrollDifference;

                    // Setelah load more, kita mungkin perlu memperbarui status polling
                    // Jika user kembali ke bawah setelah load more
                    this.updateScrollState();
                });
            });
        },

        updateScrollState() {
            const el = this.$refs.messagesDiv;
            // Toleransi 1px untuk isAtBottom
            this.isAtBottom = (el.scrollHeight - el.scrollTop) <= (el.clientHeight + 1);

            // Kontrol polling Livewire berdasarkan posisi scroll
            if (!this.isAtBottom && @js($pollingEnabled)) {
                $wire.pollingEnabled = false; // Matikan polling jika scroll ke atas
            } else if (this.isAtBottom && !@js($pollingEnabled)) {
                // Jika user scroll kembali ke bawah, polling akan otomatis aktif
                // jika ada alasan (dihandle oleh checkPollingStatus di Livewire)
                // Jadi, tidak perlu langsung memanggil $wire.pollingEnabled = true di sini
            }
        },

        checkScrollTopForLoadMore() {
            const el = this.$refs.messagesDiv;
            // Jika scroll berada di dekat paling atas (50px dari top) DAN masih ada pesan lama
            if (el.scrollTop < 50 && @js($hasMorePages)) {
                this.previousScrollHeight = el.scrollHeight; // Simpan tinggi scroll sebelum memuat
                $wire.loadMore(); // Panggil Livewire untuk memuat pesan lama
            }
        },

        scrollToBottom() {
            const messagesDiv = this.$refs.messagesDiv;
            if (messagesDiv) {
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
                this.isAtBottom = true; // Set isAtBottom jadi true setelah scroll manual
            }
        },
    }">
    {{-- Indikator "Muat Pesan Lama" --}}
    @if ($hasMorePages)
    <div class="text-center p-2 text-blue-500 hover:underline cursor-pointer" wire:click="loadMore">
      Muat pesan lebih lama...
    </div>
    @else
    <div class="text-center p-2 text-gray-400">
      Tidak ada pesan sebelumnya.
    </div>
    @endif
    {{-- Kotak Pesan --}}
    <div x-ref="messagesDiv" class="flex-grow p-4 overflow-y-auto" wire:poll.{{ $pollingEnabled ? '2s' : 'none' }}="pollMessages">
      @forelse ($conversation->messages as $message)
      @php
      // Ubah $message->sender_id menjadi integer sebelum perbandingan
      $isSender = ((int) $message->sender_id === Auth::id());
      @endphp

      {{-- Gunakan komponen chat DaisyUI --}}
      <div @class([ 'chat' , 'chat-end'=> $isSender, // Pesan dari pengirim (kamu) ada di kanan
        'chat-start' => !$isSender, // Pesan dari lawan bicara (admin) ada di kiri
        ])>
        <div @class([ 'chat-bubble' , 'chat-bubble-primary'=> $isSender])>
          {!! nl2br(e($message->content)) !!}
          <div class="chat-footer opacity-50">
            <time class="text-xs opacity-50">{{ $message->created_at->format('H:i') }}</time>
            @if ($isSender) {{-- Hanya tampilkan status untuk pesan yang kita kirim --}}
            @if ($message->is_read)
            <x-icon name="lucide.check-check" class="w-3 h-3 inline-block ml-1 text-success" /> {{-- GUNAKAN x-mary-icon --}}
            @else
            <x-icon name="lucide.check-check" class="w-3 h-3 inline-block ml-1" /> {{-- GUNAKAN x-mary-icon --}}
            @endif
            @else
            {{-- Kosong atau bisa tambahkan status lain jika diinginkan untuk pesan diterima --}}
            @endif
          </div>
        </div>
      </div>
      @empty
      <div class="text-center text-gray-500 py-10">
        <x-icon name="lucide.message-square-text" class="w-16 h-16 mx-auto text-gray-400" />
        <p class="mt-2 text-lg">Mulai percakapan Anda dengan admin.</p>
        <p class="text-sm mt-1 text-gray-400">Pesan Anda akan langsung sampai ke admin.</p>
      </div>
      @endforelse
    </div>

    {{-- Form Kirim Pesan --}}
    <form wire:submit.prevent="sendMessage" class="p-4 border-t bg-base-200">
      <x-textarea wire:model="newMessage" placeholder="Tulis pesan... Tekan Enter untuk kirim, Shift + Enter untuk baris baru" rows="1" x-data="{
                resize() {
                    this.$el.style.height = 'auto';
                    this.$el.style.height = Math.min(this.$el.scrollHeight, 100) + 'px';
                }
            }" x-init="resize()" @input="resize()" @keydown.enter.prevent="if (!event.shiftKey) { $wire.sendMessage(); $nextTick(() => resize()); }" @keydown.enter.shift="event.target.value += '\n'; $nextTick(() => resize());" class="w-full" autofocus />

      @error('newMessage')
      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
      @enderror
    </form>
  </div>
</div>
