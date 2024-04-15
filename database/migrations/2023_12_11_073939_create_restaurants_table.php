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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vk_group_id');
            $table->string('name');
            $table->string('img');
            $table->text('description');
            $table->string('link');
            $table->unsignedDecimal('cords_lng', 10, 6);
            $table->unsignedDecimal('cords_lat', 10, 6);
            $table->unsignedDecimal('rating');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
