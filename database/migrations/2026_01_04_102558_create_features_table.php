<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('name_es');                       // "Aire acondicionado"
            $table->string('name_en');                       // "Air conditioning"
            $table->string('icon');                          // "heroicon-o-sparkles"
            $table->string('category');                      // Validated via PHP Enum: interior, exterior, building, security, technology
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('features');
    }
};
