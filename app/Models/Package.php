<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $guarded = ['id'];

    // relasi ke model Voucher
    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }
}
