<?php

namespace App\Models;

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
    public function getStatusLabelAttribute(): string
    {
        return match (Str::lower($this->status)) {
            'settlement', 'capture' => 'Success',
            'pending' => 'Pending',
            'deny', 'cancel', 'expire' => 'Failed',
            default => Str::ucfirst($this->status),
        };
    }
}
