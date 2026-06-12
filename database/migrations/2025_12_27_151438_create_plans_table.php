<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');                          // "Starter", "Pro", "Unlimited"
            $table->string('slug')->unique();                // "starter", "pro", "unlimited"
            $table->unsignedInteger('listings_limit');       // 10, 50, 999999
            $table->decimal('price_eur', 8, 2);             // Mock price
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
