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
        Schema::create('vk_users', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedInteger('lvl')->default(0);
            $table->dateTime('ads_disabled_at')->nullable();
            $table->boolean('is_ads_disabled_always')->default(false)->nullable();
            $table->boolean('is_orders_public')->default(false)->nullable();
            $table->boolean('is_notification_enabled')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vk_users');
    }
};
