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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            // user peminjam
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali_rencana');

            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai'])
                  ->default('menunggu');

            // petugas yang menyetujui
            $table->foreignId('disetujui_oleh')
                  ->nullable()
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
