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
        Schema::create('user_favourites', function (Blueprint $table) {
            $table->primary(['vk_user_id', 'restaurant_id']);
            $table->unsignedBigInteger('vk_user_id');
            $table->unsignedBigInteger('restaurant_id');
            $table->timestamps();
        });
        Schema::table('user_favourites', function (Blueprint $table) {
            $table->foreign('vk_user_id')->references('id')->on('vk_users');
            $table->foreign('restaurant_id')->references('id')->on('restaurants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_favourites');
    }
};
