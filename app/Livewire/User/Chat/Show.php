<?php

namespace App\Livewire\User\Chat;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination; // <--- TAMBAHKAN INI

class Show extends Component
{
    use WithPagination; // <--- AKTIFKAN TRAIT INI

    public Conversation $conversation;
    public string $newMessage = '';
    public bool $pollingEnabled = true;
    public int $lastKnownMessageId = 0;

    // Properti untuk pagination
    public int $perPage = 5;
    public bool $hasMorePages = true;

    protected $paginationTheme = 'none';

    public function mount(): void
    {
        $this->conversation = Conversation::firstOrCreate(
            ['user_id' => Auth::id()],
            ['last_message_at' => now()]
        );
        $this->loadMessagesAndMarkAsRead();

        $this->lastKnownMessageId = $this->conversation->messages()->max('id') ?? 0;
        $this->checkPollingStatus();
    }

    public function render()
    {
        $totalMessagesCount = $this->conversation->messages()->count();

        $messagesPaginator = $this->conversation->messages()
            ->latest('id')
            ->paginate($this->perPage);

        $this->hasMorePages = $messagesPaginator->hasMorePages();

        $messages = $messagesPaginator->getCollection()->reverse();

        return view('livewire.user.chat.show', [
            'messages' => $messages,
            'hasMorePages' => $this->hasMorePages,
        ]);
    }

    public function sendMessage(): void
    {
        $this->validate([
            'newMessage' => 'required|string|max:1000',
        ]);

        $message = $this->conversation->messages()->create([
            'sender_id' => Auth::id(), // ID User yang sedang login
            'content' => $this->newMessage,
            'is_read' => false,
        ]);

        $this->conversation->update(['last_message_at' => now()]);

        $this->newMessage = '';
        $this->pollingEnabled = true;
        $this->lastKnownMessageId = $message->id;

        $this->dispatch('messagesUpdated');
    }

    protected function loadMessagesAndMarkAsRead(): void
    {
        $this->conversation->messages()
            ->where('sender_id', $this->conversation->admin_id) // Pesan dari Admin
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->updateLastKnownMessageId();
    }

    protected function updateLastKnownMessageId(): void
    {
        $this->lastKnownMessageId = $this->conversation->messages()->max('id') ?? 0;
    }

    public function checkPollingStatus(): void
    {
        $latestMessageInDb = Message::where('conversation_id', $this->conversation->id)
            ->latest('id')
            ->first(['id', 'sender_id', 'is_read']);

        $pollingNeeded = false;

        if ($latestMessageInDb) {
            $hasUnreadFromOther = (
                $latestMessageInDb->id > $this->lastKnownMessageId &&
                $latestMessageInDb->sender_id === $this->conversation->admin_id && // Dari Admin
                !$latestMessageInDb->is_read // Belum dibaca oleh User (kita)
            );

            $hasPendingReadReceipts = $this->conversation->messages()
                ->where('sender_id', Auth::id()) // Pesan yang dikirim oleh User
                ->where('is_read', false)
                ->exists();

            $pollingNeeded = $hasUnreadFromOther || $hasPendingReadReceipts;
        }

        $this->pollingEnabled = $pollingNeeded;
    }

    public function pollMessages(): void
    {
        $this->conversation->refresh();
        $this->loadMessagesAndMarkAsRead();
        $this->checkPollingStatus();

        $this->dispatch('messagesUpdated');
    }

    public function loadMore(): void
    {
        $this->perPage += 10;
        $this->dispatch('messagesLoaded');
    }
}
