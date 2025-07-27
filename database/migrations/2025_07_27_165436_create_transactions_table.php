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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa yang membayar
            $table->foreignId('package_id')->constrained()->onDelete('cascade'); // Paket apa yang dibeli
            $table->string('order_id')->unique(); // ID pesanan dari Midtrans
            $table->string('transaction_id')->nullable(); // Transaction ID Midtrans
            $table->string('payment_type')->nullable(); // e.g. gopay, bank_transfer
            $table->string('status')->default('pending'); // pending, success, failed
            $table->decimal('amount', 12, 2); // Jumlah dibayar
            $table->string('package_name')->nullable(); // Nama paket saat itu
            $table->json('raw_response')->nullable(); // Simpan semua response dari Midtrans (opsional)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
