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
        Schema::create('user_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vk_user_id');
            $table->unsignedBigInteger('dish_id');
            $table->string('status');
            $table->json('dish_options');
            $table->json('extra_options')->nullable();
            $table->string('delivery_address_city')->nullable();
            $table->string('delivery_address_street')->nullable();
            $table->string('delivery_address_house')->nullable();
            $table->string('delivery_address_apartment')->nullable();
            $table->string('delivery_address_entrance')->nullable();
            $table->string('delivery_address_floor')->nullable();
            $table->string('delivery_address_comment')->nullable();
            $table->unsignedDecimal('discount')->nullable();
            $table->dateTime('delivery_planned_at')->nullable();
            $table->unsignedDecimal('delivery_price')->nullable();
            $table->unsignedDecimal('total_price')->nullable();
            $table->unsignedDecimal('rate')->nullable();
            $table->timestamps();
        });
        Schema::table('user_orders', function (Blueprint $table) {
            $table->foreign('vk_user_id')->references('id')->on('vk_users');
            $table->foreign('dish_id')->references('id')->on('dishes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_orders');
    }
};
