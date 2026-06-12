<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add rejection_reason column if it was never actually created.
     * The previous migration (2026_04_08) is recorded as run but the column
     * may not exist in the database (e.g. after a manual DB restore).
     */
    public function up(): void
    {
        if (!Schema::hasColumn('properties', 'rejection_reason')) {
            Schema::table('properties', function (Blueprint $table) {
                // Admin rejection reason visible to the property owner
                $table->text('rejection_reason')->nullable()->after('status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('properties', 'rejection_reason')) {
            Schema::table('properties', function (Blueprint $table) {
                $table->dropColumn('rejection_reason');
            });
        }
    }
};
