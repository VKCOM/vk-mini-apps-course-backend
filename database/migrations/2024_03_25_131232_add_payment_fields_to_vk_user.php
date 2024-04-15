<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vk_users', function (Blueprint $table) {
            $table->boolean('is_vk_pay_enabled')->default(false)->after('is_notification_enabled');
            $table->boolean('is_donates_enabled')->default(false)->after('is_vk_pay_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vk_users', function (Blueprint $table) {
            $table->dropColumn('is_vk_pay_enabled');
            $table->dropColumn('is_donates_enabled');
        });
    }
};
