<?php

namespace App\Models;

use App\Casts\DishOptionsCast;
use App\Casts\ExtraDishOptionsCast;
use App\Dto\DishOption;
use App\Dto\ExtraDishOption;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Dish
 *
 * @property int $id
 * @property int $restaurant_id
 * @property string $name
 * @property string $small_img
 * @property string $full_img
 * @property float $price
 * @property int $bonus
 * @property DishOption[] $dish_options
 * @property ExtraDishOption[] $extra_options
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Dish newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereDishOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereExtraOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereFullImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereRestaurantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereSmallImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereUpdatedAt($value)
 * @property string $description
 * @property-read \App\Models\Restaurant $restaurant
 * @method static \Illuminate\Database\Eloquent\Builder|Dish whereDescription($value)
 * @mixin \Eloquent
 */
class Dish extends Model
{
    use HasFactory;

    protected $casts = [
        'dish_options' => DishOptionsCast::class,
        'extra_options' => ExtraDishOptionsCast::class,
        'price' => 'float',
    ];

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }
}
