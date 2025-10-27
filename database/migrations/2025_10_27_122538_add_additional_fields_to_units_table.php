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
        Schema::table('units', function (Blueprint $table) {
            $table->string('merk')->nullable()->after('nama_unit');
            $table->string('kapasitas')->nullable()->after('merk');
            $table->decimal('harga_sewa_per_hari', 10, 2)->nullable()->after('kapasitas');
            $table->decimal('denda_per_hari', 10, 2)->nullable()->after('harga_sewa_per_hari');
            $table->decimal('harga_beli', 12, 2)->nullable()->after('denda_per_hari');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn([
                'merk',
                'kapasitas',
                'harga_sewa_per_hari',
                'denda_per_hari',
                'harga_beli'
            ]);
        });
    }
};
