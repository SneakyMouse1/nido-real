<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Add nullable slug column
        Schema::table('property_types', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name_en');
        });

        // Step 2: Generate slugs for existing records
        foreach (\DB::table('property_types')->get() as $type) {
            \DB::table('property_types')
                ->where('id', $type->id)
                ->update(['slug' => Str::slug($type->name_es)]);
        }

        // Step 3: Make slug not null and add unique index
        Schema::table('property_types', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('property_types', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
