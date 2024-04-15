<?php

namespace App\Models;

use App\Enums\AchievementsCodeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Achievement
 *
 * @property int $id
 * @property string $title
 * @property string $img
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement whereUpdatedAt($value)
 * @property AchievementsCodeEnum $code
 * @property string $story_img
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Achievement whereStoryImg($value)
 * @mixin \Eloquent
 */
class Achievement extends Model
{
    use HasFactory;

    public const ALL_ACHIEVEMENTS_LIST = 'all_achievements_list';

    protected $casts = [
        'code' => AchievementsCodeEnum::class
    ];
}
