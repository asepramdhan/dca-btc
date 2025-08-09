<?php

namespace App\Events;

use App\Models\ChatMessage;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // public Message $message;
    // public Conversation $conversation;
    public function __construct(public ChatMessage $message)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('testing-chat.' . $this->message->receiver_id),
        ];
    }
    public function broadcastWith(): array
    {
        return [
            "id" => $this->message->id,
            "sender_id" => $this->message->sender_id,
            "receiver_id" => $this->message->receiver_id,
            "message" => $this->message->message
        ];
    }
}
