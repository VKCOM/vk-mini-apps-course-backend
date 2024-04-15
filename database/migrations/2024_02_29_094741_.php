<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Db::table('donate_items')->insert([
            ['title' => 'Отключить рекламу навсегда', 'description' => 'Отключить рекламу навсегда', 'price' => 10, 'code' => 'one_time_vote', 'period' => null, 'discount' => 0],
            ['title' => 'Отключить рекламу на месяц', 'description' => 'Отключить рекламу на месяц', 'price' => 3, 'code' => 'subscribe_vote', 'period' => 30, 'discount' => 0],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Db::table('donate_item')->whereIn('code', ['one_time_vote', 'subscribe_vote'])->delete();
    }
};
