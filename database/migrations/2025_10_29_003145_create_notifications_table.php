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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'return_request', 'rental_approved', etc.
            $table->unsignedBigInteger('user_id'); // who triggered the notification
            $table->unsignedBigInteger('peminjaman_id'); // related rental
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // additional data
            $table->timestamp('read_at')->nullable();
            $table->boolean('is_admin_notification')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('peminjaman_id')->references('id')->on('peminjamans')->onDelete('cascade');
            $table->index(['is_admin_notification', 'read_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
