<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $guarded = ['id'];

    // relasi ke model user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Relasi One-to-Many: Satu Voucher bisa dimiliki oleh banyak Transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
        // Laravel secara otomatis akan mencari foreign key 'voucher_id' di tabel 'transactions'
        // dan local key 'id' di tabel 'vouchers'
    }
    // relasi ke model Package
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
