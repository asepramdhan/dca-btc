<?php

namespace App\Livewire\Admin\Chat;

use App\Models\Conversation;
use App\Models\User;
use App\Traits\MiniToast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use MiniToast, WithPagination;

    public string $search = ''; // untuk mencari percakapan
    public string $searchUsers = ''; // untuk mencari user baru
    public function render()
    {
        // Ambil percakapan yang relevan untuk admin
        $conversations = Conversation::query()
            ->with(['user', 'admin']) // Eager load user dan admin
            ->where(function (Builder $query) {
                // Admin hanya melihat chat yang sudah di-assign ke mereka, atau yang belum di-assign (untuk diambil)
                $query->where('admin_id', Auth::id())
                    ->orWhereNull('admin_id'); // Admin bisa melihat chat yang belum ada adminnya
            })
            ->when($this->search, function (Builder $query) {
                $query->where(function (Builder $subQuery) {
                    $subQuery->whereHas('user', function (Builder $userQuery) {
                        $userQuery->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    })
                        ->orWhere('subject', 'like', '%' . $this->search . '%');
                });
            })
            ->withCount(['messages' => function (Builder $query) {
                // Hitung pesan belum dibaca yang dikirim oleh user, dan ditujukan ke admin ini
                $query->where('sender_id', '!=', Auth::id()) // Pesan dari lawan bicara (user)
                    ->where('is_read', false); // Dan belum dibaca
            }])
            ->orderByDesc('last_message_at')
            ->paginate(10);
        return view('livewire.admin.chat.index', [
            'conversations' => $conversations,
        ]);
    }
    // Method untuk memulai/membuka chat detail
    public function openChat(Conversation $conversation)
    {
        // Jika percakapan belum punya admin, assign ke admin yang sedang login
        if ($conversation->admin_id === null) {
            $conversation->update(['admin_id' => Auth::id()]);
        }
        $this->redirect('/admin/chat/' . $conversation->id, navigate: true);
    }
    // Method untuk memulai chat baru dengan user (dipanggil dari form pencarian user)
    public function startNewChat(User $user)
    {
        // Cek apakah sudah ada percakapan antara user ini dan admin yang sedang login
        $conversation = Conversation::forUser($user->id)
            ->where('admin_id', Auth::id())
            ->first();

        if (!$conversation) {
            // Buat percakapan baru jika belum ada
            $conversation = Conversation::create([
                'user_id' => $user->id,
                'admin_id' => Auth::id(),
                'subject' => 'Chat with ' . $user->name,
                'last_message_at' => now(), // Inisialisasi waktu pesan terakhir
            ]);
        }
        $this->redirect('/admin/chat/' . $conversation->id, navigate: true);
    }
    // Livewire method untuk pencarian user yang akan memulai chat baru
    public function getUsersForNewChatProperty(): Collection
    {
        if (strlen($this->searchUsers) < 3) {
            return collect(); // Jangan cari jika input terlalu pendek
        }

        return User::where('is_admin', false) // Hanya user biasa
            ->where(function (Builder $query) {
                $query->where('name', 'like', '%' . $this->searchUsers . '%')
                    ->orWhere('email', 'like', '%' . $this->searchUsers . '%');
            })
            ->limit(5)
            ->get();
    }
}
