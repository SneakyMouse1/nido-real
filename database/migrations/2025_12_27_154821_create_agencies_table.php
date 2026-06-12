<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('plans')->onDelete('restrict');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo_path')->nullable();         // Agency logo
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('cif')->nullable();               // Spanish tax number (CIF)
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('listings_used')->default(0);  // Counter of used listings
            $table->unsignedInteger('listings_limit')->default(10); // Snapshot of plan limit (updated on plan change)
            $table->timestamp('plan_changed_at')->nullable();       // Last plan change date
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agencies');
    }
};
