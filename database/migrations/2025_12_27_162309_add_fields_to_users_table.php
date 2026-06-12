<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);     // false = blocked
            $table->string('phone')->nullable();
            $table->string('avatar_path')->nullable();
            $table->string('locale')->default('es');         // User interface language
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'phone', 'avatar_path', 'locale']);
        });
    }
};
