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
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vk_user_id');
            $table->boolean('is_viewed')->default(false);
            $table->string('title');
            $table->string('text');
            $table->string('img');
            $table->string('status');
            $table->dateTime('date');
            $table->string('action_type')->nullable();
            $table->string('action_title')->nullable();
            $table->string('action_link')->nullable();
            $table->unsignedBigInteger('action_order_id')->nullable();
            $table->timestamps();
        });

        Schema::table('user_notifications', function (Blueprint $table) {
            $table->foreign('vk_user_id')->references('id')->on('vk_users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notifications');
    }
};
