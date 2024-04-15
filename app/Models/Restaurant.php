<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Restaurant
 *
 * @property int $id
 * @property int $vk_group_id
 * @property string $name
 * @property string $img
 * @property string $description
 * @property string $link
 * @property string $cords_lng
 * @property string $cords_lat
 * @property string $rating
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereCordsLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereCordsLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Restaurant whereVkGroupId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Dish> $dishes
 * @property-read int|null $dishes_count
 * @mixin \Eloquent
 */
class Restaurant extends Model
{
    use HasFactory;

    protected $casts = [
        'rating' => 'float',
        'cords_lng' => 'float',
        'cords_lat' => 'float',
    ];

    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class, 'restaurant_id');
    }
}
