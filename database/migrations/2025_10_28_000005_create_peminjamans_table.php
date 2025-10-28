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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');

            // Rental information
            $table->string('kode_peminjaman')->unique(); // Kode unik peminjaman
            $table->date('tanggal_pinjam'); // Tanggal mulai pinjam
            $table->date('tanggal_kembali_rencana'); // Tanggal rencana kembali
            $table->date('tanggal_kembali_aktual')->nullable(); // Tanggal aktual kembali

            // Status management
            $table->enum('status', ['pending', 'dipinjam', 'dikembalikan', 'terlambat', 'dibatalkan'])
                  ->default('pending');

            // Financial information
            $table->decimal('harga_sewa_total', 12, 2); // Total harga sewa
            $table->decimal('denda_total', 12, 2)->default(0); // Total denda
            $table->decimal('total_bayar', 12, 2); // Total yang harus dibayar

            // Additional information
            $table->text('catatan_peminjam')->nullable(); // Catatan dari peminjam
            $table->text('catatan_admin')->nullable(); // Catatan dari admin

            $table->timestamps();

            // Indexes for better performance
            $table->index('kode_peminjaman');
            $table->index('status');
            $table->index('tanggal_pinjam');
            $table->index('tanggal_kembali_rencana');
            $table->index(['user_id', 'status']);
            $table->index(['unit_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
