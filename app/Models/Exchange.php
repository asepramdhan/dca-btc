<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    protected $guarded = ['id'];
    // relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // relasi ke model Dca
    public function dcas()
    {
        return $this->hasMany(Dca::class);
    }
}
