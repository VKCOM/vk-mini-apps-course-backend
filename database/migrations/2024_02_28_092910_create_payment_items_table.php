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
        Schema::create('donate_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable()->default(null);
            $table->integer('price');
            $table->integer('discount')->default(0);
            $table->integer('period')->nullable()->default(null);
            $table->string('code', 25);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_items');
    }
};
