<?php

namespace App\Livewire\Admin\Chat; // Atau App\Livewire\User\Chat

use Livewire\Component;
use Livewire\WithPagination; // <--- TAMBAHKAN INI
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class Show extends Component
{
    use WithPagination; // <--- AKTIFKAN TRAIT INI

    public Conversation $conversation;
    public string $newMessage = '';
    public bool $pollingEnabled = true; // Default: polling aktif
    public int $lastKnownMessageId = 0; // ID pesan terakhir yang diproses

    // Properti untuk pagination
    public int $perPage = 10; // Jumlah pesan awal yang akan dimuat
    public bool $hasMorePages = true; // Untuk melacak apakah ada pesan lebih lama

    protected $paginationTheme = 'none'; // Kita akan mengelola tombol/indikator "Load More" secara manual

    public function mount(Conversation $conversation): void
    {
        $this->conversation = $conversation;
        $this->loadMessagesAndMarkAsRead(); // Ini akan memuat pesan & menandai dibaca

        // Inisialisasi lastKnownMessageId berdasarkan pesan terakhir yang ada di DB
        $this->lastKnownMessageId = $this->conversation->messages()->max('id') ?? 0;

        $this->checkPollingStatus(); // Tentukan status polling awal
    }

    public function render()
    {
        // Mendapatkan total semua pesan untuk percakapan ini
        $totalMessagesCount = $this->conversation->messages()->count();

        // Mengambil pesan dengan urutan DESCENDING (terbaru dulu)
        // Kemudian kita membalikkannya untuk tampilan kronologis yang benar di Blade
        $messagesPaginator = $this->conversation->messages()
            ->latest('id') // Ambil pesan terbaru terlebih dahulu
            ->paginate($this->perPage);

        // Update status hasMorePages
        $this->hasMorePages = $messagesPaginator->hasMorePages();

        // Ambil semua pesan dari paginator dan balikkan urutannya
        $messages = $messagesPaginator->getCollection()->reverse();

        // Mengirimkan pesan yang sudah diurutkan dan status hasMorePages ke view
        return view('livewire.admin.chat.show', [
            'messages' => $messages,
            'hasMorePages' => $this->hasMorePages, // Kirim ke Blade
        ]);
    }

    // Mengirim pesan dari admin ke user
    public function sendMessage(): void
    {
        $this->validate([
            'newMessage' => 'required|string|max:1000',
        ]);

        $message = $this->conversation->messages()->create([
            'sender_id' => Auth::id(),
            'content' => $this->newMessage,
            'is_read' => false,
        ]);

        $this->conversation->update(['last_message_at' => now()]);

        $this->newMessage = '';

        // Setelah mengirim pesan, pastikan polling aktif untuk memantau status 'dibaca'
        $this->pollingEnabled = true;
        // Kita juga perlu memastikan pesan baru ini muncul di tampilan tanpa harus loadMore
        // Jika messages sudah dimuat dalam jumlah yang cukup (misal 10), ini akan otomatis terhandle di render.
        // Jika perlu, kita bisa reset perPage ke nilai awal atau memastikan pesan baru masuk ke koleksi.
        // Untuk saat ini, kita biarkan render() yang menghandle load terbaru.
        $this->lastKnownMessageId = $message->id; // Update lastKnownMessageId

        // Dispatch event untuk Alpine.js agar scroll ke bawah untuk pesan baru
        $this->dispatch('messagesUpdated');
    }

    // Method untuk memuat pesan dan menandai pesan user sebagai sudah dibaca
    protected function loadMessagesAndMarkAsRead(): void
    {
        // Tidak perlu load(['messages.sender']) di sini, karena sudah di-load di render() dengan paginate
        // $this->conversation->load(['messages.sender']);

        // Tandai pesan yang dikirim OLEH PENGGUNA (bukan admin) sebagai sudah dibaca
        $this->conversation->messages()
            ->where('sender_id', $this->conversation->user_id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->updateLastKnownMessageId();
    }

    protected function updateLastKnownMessageId(): void
    {
        $this->lastKnownMessageId = $this->conversation->messages()->max('id') ?? 0;
    }

    // Logika utama untuk mengaktifkan/menonaktifkan wire:poll
    public function checkPollingStatus(): void
    {
        $latestMessageInDb = Message::where('conversation_id', $this->conversation->id)
            ->latest('id')
            ->first(['id', 'sender_id', 'is_read']);

        $pollingNeeded = false;

        if ($latestMessageInDb) {
            // Kondisi 1: Ada pesan baru dari lawan bicara yang belum kita lihat/baca.
            $hasUnreadFromOther = (
                $latestMessageInDb->id > $this->lastKnownMessageId && // Ada pesan baru secara ID
                // Untuk Admin: Pesan dari User ($this->conversation->user_id adalah ID user di chat ini)
                $latestMessageInDb->sender_id === $this->conversation->user_id &&
                !$latestMessageInDb->is_read // Belum dibaca oleh Admin (kita)
            );

            // Kondisi 2: Ada pesan yang kita (Admin) kirim tapi belum dibaca oleh lawan bicara (User).
            $hasPendingReadReceipts = $this->conversation->messages()
                ->where('sender_id', Auth::id()) // Pesan yang dikirim oleh Admin
                ->where('is_read', false) // Belum dibaca lawan bicara
                ->exists();

            $pollingNeeded = $hasUnreadFromOther || $hasPendingReadReceipts;
        }

        $this->pollingEnabled = $pollingNeeded;
    }

    // Listener untuk wire:poll
    public function pollMessages(): void
    {
        $this->conversation->refresh(); // Refresh conversation data
        $this->loadMessagesAndMarkAsRead(); // Ini akan memperbarui is_read dan lastKnownMessageId
        $this->checkPollingStatus(); // Perbarui status polling

        $this->dispatch('messagesUpdated'); // Dispatch event ke Alpine.js untuk scroll & re-render
    }

    /**
     * Metode ini dipanggil saat pengguna menggulir ke atas untuk memuat lebih banyak pesan.
     */
    public function loadMore(): void
    {
        $this->perPage += 10; // Tambah jumlah pesan yang akan dimuat
        // Livewire akan otomatis me-render ulang component
        $this->dispatch('messagesLoaded'); // Dispatch event ke Alpine.js untuk penyesuaian scroll
    }
}
