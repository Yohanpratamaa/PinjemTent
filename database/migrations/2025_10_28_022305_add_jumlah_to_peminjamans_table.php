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
            // Add jumlah column after unit_id
            $table->integer('jumlah')->default(1)->after('unit_id')
                  ->comment('Jumlah unit yang dipinjam');

            // Add index for better performance when calculating active rentals
            $table->index(['unit_id', 'status', 'jumlah']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            // Drop index first
            $table->dropIndex(['unit_id', 'status', 'jumlah']);

            // Drop the jumlah column
            $table->dropColumn('jumlah');
        });
    }
};
