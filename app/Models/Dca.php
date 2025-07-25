<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dca extends Model
{
    protected $guarded = ['id'];

    // relasi ke model Exchange
    public function exchange()
    {
        return $this->belongsTo(Exchange::class);
    }
}
