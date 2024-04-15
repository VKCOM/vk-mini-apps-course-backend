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
        Schema::create('donate_orders', function (Blueprint $table) {
            $table->id();
            $table->string('external_order_id')->index('external_order_id_ind');
            $table->string('subscription_id')->index('subscription_id_ind');
            $table->foreignIdFor(\App\Models\DonateItem::class);
            $table->foreignIdFor(\App\Models\VkUser::class);
            $table->integer('price');
            $table->dateTime('active_to')->nullable();
            $table->string('type');
            $table->string('status');
            $table->json('meta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donate_orders');
    }
};
