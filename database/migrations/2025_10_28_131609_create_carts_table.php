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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->text('notes')->nullable();
            $table->decimal('harga_per_hari', 10, 2);
            $table->decimal('total_harga', 10, 2);
            $table->timestamps();

            // Constraint untuk memastikan user tidak menambahkan unit yang sama dengan tanggal yang sama
            $table->unique(['user_id', 'unit_id', 'tanggal_mulai', 'tanggal_selesai']);

            // Indexes untuk performance
            $table->index('user_id');
            $table->index('unit_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
