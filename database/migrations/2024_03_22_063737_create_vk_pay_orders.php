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
        Schema::create('vk_pay_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\UserOrder::class);
            $table->uuid('order_uuid');
            $table->string('transaction_id');
            $table->float('amount');
            $table->string('currency');
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
        Schema::dropIfExists('vk_pay_orders');
    }
};
