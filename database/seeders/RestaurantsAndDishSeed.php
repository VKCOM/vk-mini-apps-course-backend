<?php

namespace Database\Seeders;

use App\Dto\DishOption;
use App\Dto\ExtraDishOption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class RestaurantsAndDishSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diggyRestId = DB::table('restaurants')->insertGetId([
            'name' => 'ВК Дигги кафе',
            'img' => 'restaurants/diggy.png',
            'description' => 'Пёс Дигги варит отличный кофе и обожает мемесы. В общем-то, он и сам сплошной мемес. Кек.',
            'link' => 'https://vk.com/stickers/diggy',
            'vk_group_id' => 68218830,
            'cords_lng' => 30.312636,
            'cords_lat' => 59.934634,
            'rating' => 5.0,
        ]);
        $spottyRestId = DB::table('restaurants')->insertGetId([
            'name' => 'Космическое кафе Spotty',
            'img' => 'restaurants/spotty.png',
            'description' => 'Чемпион по вилянию хвостом, верный друг и надёжная грелка. Готовит космические блюда не только в тюбиках.',
            'link' => 'https://vk.com/stickers/spotty',
            'vk_group_id' => 68218830,
            'cords_lng' => 30.316058,
            'cords_lat' => 59.93527,
            'rating' => 4.9,
        ]);
        $senyaRestId = DB::table('restaurants')->insertGetId([
            'name' => 'Рёберная by Сеня',
            'img' => 'restaurants/senya.png',
            'description' => 'Дружелюбный хомяк Сеня готовит чудесные рёбрышки и мечтает стать королём Печенькового Королевства.',
            'link' => 'https://vk.com/stickers/senya',
            'vk_group_id' => 68218830,
            'cords_lng' => 30.312374,
            'cords_lat' => 59.933903,
            'rating' => 4.5,
        ]);
        $persikRestId = DB::table('restaurants')->insertGetId([
            'name' => 'Persik Burgers',
            'img' => 'restaurants/persik.png',
            'description' => 'Самая рыжая и милая бургерная. Персик - величественный комок шерсти, обожающий спать, мурчать и играть с компьютерной мышкой.',
            'link' => 'https://vk.com/stickers/persik',
            'vk_group_id' => 68218830,
            'cords_lng' => 30.314884,
            'cords_lat' => 59.933404,
            'rating' => 3.7,
        ]);

        DB::table('dishes')->insert([
            'restaurant_id' => $diggyRestId,
            'name' => 'Котлета с пюрешкой',
            'description' => 'Любимое всеми домашнее блюдо - нежное картофельное пюре и сочная домашняя котлета из курицы.',
            'small_img' => 'dishes/cutlet_potato.small.jpeg',
            'full_img' => 'dishes/cutlet_potato.full.jpeg',
            'price' => 400,
            'bonus' => 2,
            'dish_options' => json_encode([
                new DishOption(Uuid::uuid4()->toString(), 'Добавить котлету', 40),
                new DishOption(Uuid::uuid4()->toString(), 'Добавить зелень', 40),
                new DishOption(Uuid::uuid4()->toString(), 'Убрать соус', 0),
                new DishOption(Uuid::uuid4()->toString(), 'Убрать пюре', 0),
            ]),
            'extra_options' => json_encode([
                new ExtraDishOption(Uuid::uuid4()->toString(), 'Добавить приборы'),
                new ExtraDishOption(Uuid::uuid4()->toString(), 'Оставить у двери'),
            ]),
        ]);

        DB::table('dishes')->insert([
            'restaurant_id' => $spottyRestId,
            'name' => 'Пицца 4 сыра',
            'description' => 'Самое главное тут сыры, а точнее их сочетание. Здесь важно, чтобы у вас присутствовали четыре разных типа сыров: мягкий, твердый, ароматный (пряный) и голубой.',
            'small_img' => 'dishes/pizza.small.jpeg',
            'full_img' => 'dishes/pizza.full.jpeg',
            'price' => 754,
            'bonus' => 3,
            'dish_options' => json_encode([
                new DishOption(Uuid::uuid4()->toString(), 'Добавить сырные бортики', 80),
                new DishOption(Uuid::uuid4()->toString(), 'Посыпать зеленью', 40),
            ]),
            'extra_options' => json_encode([
                new ExtraDishOption(Uuid::uuid4()->toString(), 'Добавить приборы'),
                new ExtraDishOption(Uuid::uuid4()->toString(), 'Оставить у двери'),
                new ExtraDishOption(Uuid::uuid4()->toString(), 'Упаковать в фольгу'),
            ]),
        ]);

        DB::table('dishes')->insert([
            'restaurant_id' => $senyaRestId,
            'name' => 'Рёбра свиные Сеня Size',
            'description' => 'Свиные рёбра, розмарин, соус хот, кукуруза, жареный лук, сыр пармезан, сыр чеддер, кукурузные чипсы. Подаются с печёным картофелем с розмарином или фасолью в соусе тако.',
            'small_img' => 'dishes/rebra.small.jpeg',
            'full_img' => 'dishes/rebra.full.jpeg',
            'price' => 1100,
            'bonus' => 4,
            'dish_options' => json_encode([
                new DishOption(Uuid::uuid4()->toString(), 'Добавить картофель фри', 120),
                new DishOption(Uuid::uuid4()->toString(), 'Добавить запеченный картофель', 180),
            ]),
            'extra_options' => json_encode([
                new ExtraDishOption(Uuid::uuid4()->toString(), 'Оставить у двери'),
                new ExtraDishOption(Uuid::uuid4()->toString(), 'Упаковать в фольгу'),
            ]),
        ]);

        DB::table('dishes')->insert([
            'restaurant_id' => $persikRestId,
            'name' => 'BBQ Burger с персиковым соусом',
            'description' => 'Такого вкусного BBQ вы еще не пробовали! Бургер с домашней булочкой, сочной котлетой из мраморной говядины Блэк Ангус, тянущимся сыром Чеддер, жареным луком, маринованными огурчиками и свежим салатом айсберг. Пикантность вкусу придает гармоничное сочетание соусов кетчуп-барбекю и 1000 островов.',
            'small_img' => 'dishes/burger.small.jpeg',
            'full_img' => 'dishes/burger.full.jpeg',
            'price' => 897,
            'bonus' => 3,
            'dish_options' => json_encode([
                new DishOption(Uuid::uuid4()->toString(), 'Салат Цезарь', 420),
                new DishOption(Uuid::uuid4()->toString(), 'Сырный соус', 60),
            ]),
            'extra_options' => json_encode([
                new ExtraDishOption(Uuid::uuid4()->toString(), 'Оставить у двери'),
                new ExtraDishOption(Uuid::uuid4()->toString(), 'Добавить приборы'),
            ]),
        ]);
    }
}
