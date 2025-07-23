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
        Schema::create('dcas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('exchange_id');
            // jumlah beli rp
            $table->integer('amount');
            // harga beli bitcoin
            $table->float('price');
            // jumlah bitcoin
            $table->float('quantity');
            // status pembelian
            $table->string('type');
            // keterangan
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dcas');
    }
};
