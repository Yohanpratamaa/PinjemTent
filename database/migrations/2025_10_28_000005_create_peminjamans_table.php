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
            $table->integer('jumlah')->default(1)->comment('Jumlah unit yang dipinjam'); // Dari add_jumlah migration

            // Rental information
            $table->string('kode_peminjaman')->unique(); // Kode unik peminjaman
            $table->date('tanggal_pinjam'); // Tanggal mulai pinjam
            $table->date('tanggal_kembali_rencana'); // Tanggal rencana kembali
            $table->date('tanggal_kembali_aktual')->nullable(); // Tanggal aktual kembali

            // Status management
            $table->enum('status', ['pending', 'dipinjam', 'dikembalikan', 'terlambat', 'dibatalkan'])
                  ->default('pending');

            // Rental approval fields (dari add_rental_approval_fields migration)
            $table->enum('rental_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('rental_approved_at')->nullable();
            $table->unsignedBigInteger('rental_approved_by')->nullable();
            $table->text('rental_rejection_reason')->nullable();

            // Return request fields (dari add_return_request_fields migration)
            $table->enum('return_status', ['not_requested', 'requested', 'approved', 'rejected'])->default('not_requested');
            $table->timestamp('return_requested_at')->nullable();
            $table->text('return_message')->nullable();
            $table->timestamp('approved_return_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();

            // Financial information
            $table->decimal('harga_sewa_total', 12, 2); // Total harga sewa
            $table->decimal('denda', 10, 2)->default(0); // Denda dari add_denda_fields migration
            $table->integer('hari_terlambat')->default(0); // Hari terlambat dari add_denda_fields migration
            $table->text('keterangan_denda')->nullable(); // Keterangan denda dari add_denda_fields migration
            $table->decimal('denda_total', 12, 2)->default(0); // Total denda
            $table->decimal('total_bayar', 12, 2); // Total yang harus dibayar

            // Additional information
            $table->text('catatan_peminjam')->nullable(); // Catatan dari peminjam
            $table->text('catatan_admin')->nullable(); // Catatan dari admin

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('rental_approved_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');

            // Indexes for better performance
            $table->index('kode_peminjaman');
            $table->index('status');
            $table->index('tanggal_pinjam');
            $table->index('tanggal_kembali_rencana');
            $table->index(['user_id', 'status']);
            $table->index(['unit_id', 'status']);
            $table->index(['unit_id', 'status', 'jumlah']); // Index tambahan dari add_jumlah migration
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
