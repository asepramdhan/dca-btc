<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TestingChat extends Component
{
    public $users;
    public $selectedUser;
    public $newMessage;
    public $messages;
    public $loginID;
    public function mount(): void
    {
        $this->users = User::whereNot("id", Auth::user()->id)->latest()->get();
        $this->selectedUser = $this->users->first();
        $this->loadMessages();
        $this->loginID = Auth::id();
    }
    public function selectUser($id): void
    {
        $this->selectedUser = User::find($id);
        $this->loadMessages();
    }
    public function loadMessages(): void
    {
        $this->messages = ChatMessage::query()
            ->where(function ($q) {
                $q->where("sender_id", Auth::id())
                    ->where("receiver_id", $this->selectedUser->id);
            })
            ->orWhere(function ($q) {
                $q->where("sender_id", $this->selectedUser->id)
                    ->where("receiver_id", Auth::id());
            })
            ->get();
    }
    public function send(): void
    {
        if (!$this->newMessage) return;
        $message = ChatMessage::create([
            "sender_id" => Auth::id(),
            "receiver_id" => $this->selectedUser->id,
            "message" => $this->newMessage
        ]);
        $this->messages->push($message);
        $this->newMessage = "";

        broadcast(new MessageSent($message));
    }
    public function getListeners()
    {
        return [
            "echo-private:testing-chat.{$this->loginID},MessageSent" => "newChatMessageNotification"
        ];
    }
    public function newChatMessageNotification($message)
    {
        if ($message["sender_id"] == $this->selectedUser->id) {
            $messageObj = ChatMessage::find($message["id"]);
            $this->messages->push($messageObj);
        }
    }
    public function render()
    {
        return view('livewire.testing-chat');
    }
}
