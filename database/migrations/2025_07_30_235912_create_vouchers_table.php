<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id(); // Kolom ID utama untuk tabel vouchers
            $table->foreignId('user_id');
            $table->string('code')->unique(); // Kode voucher, harus unik
            $table->string('type')->default('percentage'); // Contoh: 'percentage', 'fixed'
            $table->decimal('value', 8, 2); // Nilai voucher (misal: 10.00 untuk 10%, atau 50000.00 untuk 50 ribu)
            $table->timestamp('expires_at')->nullable(); // Tanggal kadaluarsa voucher
            $table->integer('usage_limit')->nullable(); // Batas penggunaan voucher (total)
            $table->integer('used_count')->default(0); // Berapa kali voucher sudah digunakan
            $table->boolean('is_active')->default(true); // Status aktif/tidak aktif
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
