<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('testing-chat.{receiver_id}', function ($user, $receiver_id) {
    return (int) $user->id === (int) $receiver_id;
});
