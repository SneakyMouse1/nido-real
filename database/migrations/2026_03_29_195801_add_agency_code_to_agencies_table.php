<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
            // Unique agency code in format: ALCGR, NIDRE, INMSO etc.
            $table->string('agency_code', 10)->unique()->nullable()->after('slug');
        });
    }

    public function down(): void
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropUnique(['agency_code']);
            $table->dropColumn('agency_code');
        });
    }
};
