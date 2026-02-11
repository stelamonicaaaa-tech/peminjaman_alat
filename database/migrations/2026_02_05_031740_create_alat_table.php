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
        Schema::create('alat', function (Blueprint $table) {
            $table->id();
            $table->string('kode_alat', 50)->unique();
            $table->string('nama_alat', 150);
            $table->foreignId('kategori_id')
                  ->constrained('kategori')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();
            $table->integer('stok');
            $table->string('kondisi', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat');
    }
};
