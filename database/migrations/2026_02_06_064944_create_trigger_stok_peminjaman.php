<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER trg_kurangi_stok_setujui
            AFTER UPDATE ON peminjaman
            FOR EACH ROW
            BEGIN
                IF OLD.status = "menunggu" AND NEW.status = "disetujui" THEN
                    UPDATE alat a
                    JOIN detail_peminjaman dp ON dp.alat_id = a.id
                    SET a.stok = a.stok - dp.jumlah
                    WHERE dp.peminjaman_id = NEW.id;
                END IF;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER trg_tambah_stok_pengembalian
            AFTER UPDATE ON peminjaman
            FOR EACH ROW
            BEGIN
                IF OLD.status = "disetujui" AND NEW.status = "selesai" THEN
                    UPDATE alat a
                    JOIN detail_peminjaman dp ON dp.alat_id = a.id
                    SET a.stok = a.stok + dp.jumlah
                    WHERE dp.peminjaman_id = NEW.id;
                END IF;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_kurangi_stok_setujui');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_tambah_stok_pengembalian');
    }
};
