<?php

namespace App\Models;

use App\Enums\UserNotificationActionTypeEnum;
use App\Enums\UserNotificationStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserNotification
 *
 * @property int $id
 * @property int $vk_user_id
 * @property int $is_viewed
 * @property string $title
 * @property string $text
 * @property string $img
 * @property UserNotificationStatusEnum $status
 * @property string $date
 * @property UserNotificationActionTypeEnum|null $action_type
 * @property string|null $action_title
 * @property int|null $action_order_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereActionLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereActionOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereActionTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereActionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereIsViewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereVkUserId($value)
 * @property-read \App\Models\VkUser $user
 * @property string|null $share_image
 * @method static \Illuminate\Database\Eloquent\Builder|UserNotification whereShareImage($value)
 * @mixin \Eloquent
 */
class UserNotification extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(VkUser::class, 'vk_user_id');
    }

    protected $casts = [
        'is_viewed' => 'boolean',
        'date' => 'datetime',
        'status' => UserNotificationStatusEnum::class,
        'action_type' => UserNotificationActionTypeEnum::class,
    ];
}
