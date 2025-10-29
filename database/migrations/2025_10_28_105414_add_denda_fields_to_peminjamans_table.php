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
        Schema::table('peminjamans', function (Blueprint $table) {
            if (!Schema::hasColumn('peminjamans', 'denda')) {
                $table->decimal('denda', 10, 2)->default(0)->after('harga_sewa_total');
            }
            if (!Schema::hasColumn('peminjamans', 'hari_terlambat')) {
                $table->integer('hari_terlambat')->default(0)->after('denda');
            }
            if (!Schema::hasColumn('peminjamans', 'keterangan_denda')) {
                $table->text('keterangan_denda')->nullable()->after('hari_terlambat');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn(['denda', 'hari_terlambat', 'keterangan_denda']);
        });
    }
};
