<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Models\Conversation; // Pastikan model Conversation sudah ada
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Pastikan model User sudah ada

class ChatNotificationBadge extends Component
{
    public int $unreadCount = 0;

    // Metode ini akan dipanggil saat komponen di-mount dan oleh wire:poll
    public function mount()
    {
        $this->getUnreadCount();
    }

    // Metode untuk menghitung pesan belum dibaca
    public function getUnreadCount()
    {
        if (!Auth::check()) {
            $this->unreadCount = 0;
            return;
        }

        $userId = Auth::id();
        $user = Auth::user(); // Dapatkan instance user yang sedang login

        // Asumsi: model User punya kolom 'is_admin' atau method 'isAdmin()'
        if ($user->is_admin) { // Jika user adalah admin
            // Admin: hitung pesan belum dibaca dari SEMUA user yang percakapannya dia kelola
            // Asumsi: tabel 'conversations' punya kolom 'admin_id' yang mengacu ke ID admin
            $this->unreadCount = Message::where('is_read', false)
                ->where('sender_id', '!=', $userId) // Pesan yang diterima oleh admin (bukan dikirim admin)
                ->whereHas('conversation', function ($query) use ($userId) {
                    $query->where('admin_id', $userId); // Hanya percakapan di mana admin ini terlibat
                })
                ->count();
        } else { // Jika user adalah user biasa
            // User: hitung pesan belum dibaca dari admin di percakapannya sendiri
            // Asumsi: setiap user punya 1 chat dengan admin, ditemukan via user_id di Conversation
            $conversation = Conversation::where('user_id', $userId)->first();

            if ($conversation) {
                $this->unreadCount = Message::where('is_read', false)
                    ->where('sender_id', '!=', $userId) // Pesan yang diterima oleh user (dari admin)
                    ->where('conversation_id', $conversation->id)
                    ->count();
            } else {
                $this->unreadCount = 0;
            }
        }
    }

    public function render()
    {
        return view('livewire.chat-notification-badge');
    }
}
