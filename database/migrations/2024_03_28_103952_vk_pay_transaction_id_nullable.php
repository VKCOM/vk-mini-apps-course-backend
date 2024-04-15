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
        Schema::table('vk_pay_orders', function (Blueprint $table) {
            $table->string('transaction_id')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vk_pay_orders', function (Blueprint $table) {
            $table->string('transaction_id')->nullable(false)->change();
        });
    }
};
