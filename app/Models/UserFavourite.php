<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserFavourite
 *
 * @property int $vk_user_id
 * @property int $restaurant_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavourite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavourite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavourite query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavourite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavourite whereRestaurantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavourite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserFavourite whereVkUserId($value)
 * @mixin \Eloquent
 */
class UserFavourite extends Model
{
    use HasFactory;

    protected $fillable = [
        'vk_user_id',
        'restaurant_id',
    ];
}
