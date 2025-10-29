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
        Schema::create('units', function (Blueprint $table) {
            $table->id();

            // Basic unit information
            $table->string('kode_unit')->unique(); // Kode unit harus unik
            $table->string('nama_unit'); // Nama unit bisa sama
            $table->string('merk')->nullable(); // Brand/merk unit
            $table->string('kapasitas')->nullable(); // Kapasitas unit (misal: 4 orang, 6 orang)
            $table->text('deskripsi')->nullable(); // Deskripsi lengkap unit
            $table->string('foto')->nullable(); // Foto unit

            // Status and stock management
            $table->enum('status', ['tersedia', 'dipinjam', 'maintenance'])->default('tersedia');
            $table->integer('stok')->default(1); // Jumlah unit tersedia

            // Pricing information
            $table->decimal('harga_sewa_per_hari', 10, 2)->nullable(); // Harga sewa per hari
            $table->decimal('denda_per_hari', 10, 2)->nullable(); // Denda keterlambatan per hari
            $table->decimal('harga_beli', 12, 2)->nullable(); // Harga beli/investasi unit

            $table->timestamps();

            // Indexes for better performance
            $table->index('kode_unit');
            $table->index('status');
            $table->index('nama_unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
