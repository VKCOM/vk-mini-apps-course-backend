<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AchivementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('achievements')->insertGetId([
            'code' => 'first_order',
            'title' => 'Первый заказ',
            'img' => 'achivements/first_order.png',
            'story_img' => 'achivements/first_order.story.png',
        ]);
        DB::table('achievements')->insertGetId([
            'code' => 'favourite',
            'title' => 'Добавить избранное',
            'img' => 'achivements/favorite.png',
            'story_img' => 'achivements/favorite.story.png',
        ]);
        DB::table('achievements')->insertGetId([
            'code' => 'orders5',
            'title' => 'Сделать 5 заказов',
            'img' => 'achivements/5orders.png',
            'story_img' => 'achivements/5orders.story.png',
        ]);
        DB::table('achievements')->insertGetId([
            'code' => 'orders8',
            'title' => 'Сделать 8 заказов',
            'img' => 'achivements/8orders.png',
            'story_img' => 'achivements/8orders.story.png',
        ]);
    }
}
