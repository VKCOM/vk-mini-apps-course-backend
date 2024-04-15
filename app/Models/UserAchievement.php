<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserAchievement
 *
 * @property int $vk_user_id
 * @property int $achievement_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserAchievement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAchievement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAchievement query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAchievement whereAchievementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAchievement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAchievement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAchievement whereVkUserId($value)
 * @property Achievement $achievement
 * @mixin \Eloquent
 */
class UserAchievement extends Model
{
    use HasFactory;
    protected $fillable = [
        'vk_user_id',
        'achievement_id',
    ];

    public function achievement(): BelongsTo
    {
        return $this->belongsTo(Achievement::class, 'achievement_id');
    }
}
