<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // make nullable: commercial props may not have bedrooms/bathrooms/area
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->unsignedSmallInteger('bedrooms')->nullable()->default(null)->change();
            $table->unsignedSmallInteger('bathrooms')->nullable()->default(null)->change();
            $table->unsignedInteger('area_total')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->unsignedSmallInteger('bedrooms')->nullable(false)->default(0)->change();
            $table->unsignedSmallInteger('bathrooms')->nullable(false)->default(0)->change();
            $table->unsignedInteger('area_total')->nullable(false)->change();
        });
    }
};
