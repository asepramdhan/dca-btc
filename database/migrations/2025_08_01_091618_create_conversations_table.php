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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            // foreignId ke user yang memulai atau terlibat (user biasa)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // foreignId ke admin yang terlibat. Bisa nullable jika admin belum merespon atau memilih chat.
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('subject')->nullable(); // Opsional: subjek percakapan
            $table->timestamp('last_message_at')->nullable(); // Untuk sorting percakapan terbaru
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
