<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Agent contact fields (phone already exists)
            $table->string('phone_secondary')->nullable()->after('phone');
            $table->string('whatsapp')->nullable()->after('phone_secondary');
            $table->string('address')->nullable()->after('whatsapp');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_secondary', 'whatsapp', 'address']);
        });
    }
};
