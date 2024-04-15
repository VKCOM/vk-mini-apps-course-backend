<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->string('name');
            $table->text('description');
            $table->string('small_img');
            $table->string('full_img');
            $table->unsignedDecimal('price');
            $table->unsignedInteger('bonus');
            $table->json('dish_options');
            $table->json('extra_options');
            $table->timestamps();
        });

        Schema::table('dishes', function (Blueprint $table) {
            $table->foreign('restaurant_id')->references('id')->on('restaurants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dishes');
    }
};
