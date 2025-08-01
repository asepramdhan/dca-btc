<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // Ini penting!
        ];
    }
    // relasi ke model Transaction
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
    // relasi ke model Voucher
    public function vouchers(): HasMany
    {
        return $this->hasMany(Voucher::class);
    }
    // Helper untuk mengecek apakah user ini admin
    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    // Relasi opsional jika user bisa punya banyak percakapan sebagai admin
    public function conversationsAsUser(): HasMany
    {
        return $this->hasMany(Conversation::class, 'user_id');
    }

    // Relasi opsional jika user bisa punya banyak percakapan sebagai admin
    public function conversationsAsAdmin(): HasMany
    {
        return $this->hasMany(Conversation::class, 'admin_id');
    }

    // Relasi untuk pesan yang dikirim oleh user ini
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
}
