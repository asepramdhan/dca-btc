<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['is_read' => 'boolean'];
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function scopeUnread(Builder $query): void
    {
        $query->where('is_read', false);
    }
}
