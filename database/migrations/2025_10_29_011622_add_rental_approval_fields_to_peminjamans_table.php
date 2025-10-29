<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('peminjamans', 'rental_status')) {
                $table->enum('rental_status', ['pending', 'approved', 'rejected'])->default('pending')->after('status');
            }
            if (!Schema::hasColumn('peminjamans', 'rental_approved_at')) {
                $table->timestamp('rental_approved_at')->nullable()->after('rental_status');
            }
            if (!Schema::hasColumn('peminjamans', 'rental_approved_by')) {
                $table->unsignedBigInteger('rental_approved_by')->nullable()->after('rental_approved_at');
            }
            if (!Schema::hasColumn('peminjamans', 'rental_rejection_reason')) {
                $table->text('rental_rejection_reason')->nullable()->after('rental_approved_by');
            }
        });

        // Add foreign key constraint separately if it doesn't exist
        if (!DB::select("SELECT * FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_NAME = 'peminjamans' AND COLUMN_NAME = 'rental_approved_by' AND CONSTRAINT_NAME LIKE '%foreign%'")) {
            Schema::table('peminjamans', function (Blueprint $table) {
                $table->foreign('rental_approved_by')->references('id')->on('users')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropForeign(['rental_approved_by']);
            $table->dropColumn([
                'rental_status',
                'rental_approved_at',
                'rental_approved_by',
                'rental_rejection_reason'
            ]);
        });
    }
};
