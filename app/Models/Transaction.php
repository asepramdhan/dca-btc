<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    protected $guarded = ['id'];

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // relasi ke package
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    // 
    public function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => match ($this->status) {
                'pending' => 'Pending',
                'settlement', 'capture' => 'Success',
                'deny', 'failure' => 'Failed',
                'expire', 'cancel' => 'Expired', // ✅ Tambahkan 'expire' di sini
                default => ucfirst($this->status ?? 'N/A'),
            },
        );
    }
}
