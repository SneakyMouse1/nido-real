<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // Auto-generated code: NR-{AGENCY_CODE}-{ID padded to 6 digits}
            $table->string('property_code', 20)->unique()->nullable()->after('slug');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropUnique(['property_code']);
            $table->dropColumn('property_code');
        });
    }
};
