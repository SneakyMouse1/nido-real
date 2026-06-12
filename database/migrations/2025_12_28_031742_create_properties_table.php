<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            // Ownership
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('agency_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('property_type_id')->constrained()->onDelete('restrict');

            // Content
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('video_url')->nullable();

            // Financials
            $table->decimal('price', 12, 2);
            $table->string('deal_type');                         // 'sale' or 'rent' — validated via PHP Enum
            $table->decimal('price_per_sqm', 10, 2)->nullable(); // Auto-calculated

            // Status
            $table->string('status')->default('draft');          // Validated via PHP Enum

            // Characteristics
            $table->unsignedSmallInteger('bedrooms')->default(0);
            $table->unsignedSmallInteger('bathrooms')->default(0);
            $table->unsignedSmallInteger('toilets')->nullable();     // aseos
            $table->unsignedInteger('area_total');                   // Construidos m²
            $table->unsignedInteger('area_useful')->nullable();      // Útiles m²
            $table->string('floor_number')->nullable();              // "Bajo", "1", "Ático"
            $table->unsignedSmallInteger('total_floors')->nullable();
            $table->unsignedSmallInteger('year_built')->nullable();  // year (no ->year() in PostgreSQL)
            $table->boolean('has_garage')->default(false);
            $table->boolean('has_storage')->default(false);          // trastero

            // Spanish specifics
            $table->string('orientation')->nullable();               // Validated via PHP Enum
            $table->string('energy_certificate')->nullable();        // Validated via PHP Enum
            $table->decimal('community_fees', 8, 2)->nullable();     // €/month — gastos comunidad
            $table->decimal('ibi_tax', 8, 2)->nullable();            // €/year

            // Location
            $table->string('address_line')->nullable();
            $table->boolean('hide_exact_address')->default(false);
            $table->string('neighborhood')->nullable();              // barrio/urbanización
            $table->string('city');
            $table->string('province');
            $table->string('country')->default('España');
            $table->string('zip_code', 10)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // SEO / promo
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('views_count')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['status', 'deal_type', 'city']);
            $table->index(['agency_id', 'status']);
            $table->index('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
