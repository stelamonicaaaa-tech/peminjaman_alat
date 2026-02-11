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
        Schema::create('detail_pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengembalian_id')
                ->constrained('pengembalian')
                ->cascadeOnDelete();

            $table->foreignId('alat_id')
                ->constrained('alat')
                ->restrictOnDelete();

            $table->unsignedInteger('jumlah');

            $table->timestamps();

            // mencegah alat yang sama dicatat dua kali dalam satu pengembalian
            $table->unique(['pengembalian_id', 'alat_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pengembalian');
    }
};
