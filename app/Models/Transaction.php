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
    // Relasi Many-to-One: Banyak Transaksi menggunakan satu Voucher
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
        // Laravel secara otomatis akan mencari foreign key 'voucher_id' di tabel 'transactions'
        // dan local key 'id' di tabel 'vouchers'
    }
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
