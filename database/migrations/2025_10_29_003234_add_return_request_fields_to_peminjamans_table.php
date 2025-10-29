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
            $table->enum('return_status', ['not_requested', 'requested', 'approved', 'rejected'])->default('not_requested')->after('status');
            $table->timestamp('return_requested_at')->nullable()->after('return_status');
            $table->text('return_message')->nullable()->after('return_requested_at');
            $table->timestamp('approved_return_at')->nullable()->after('return_message');
            $table->unsignedBigInteger('approved_by')->nullable()->after('approved_return_at');

            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'return_status',
                'return_requested_at',
                'return_message',
                'approved_return_at',
                'approved_by'
            ]);
        });
    }
};
