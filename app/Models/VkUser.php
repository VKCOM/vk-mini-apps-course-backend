<?php

namespace App\Models;

use App\Enums\UserOrderStatusEnum;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\VkUser
 *
 * @property int $id
 * @property int $lvl
 * @property ?Carbon $ads_disabled_at
 * @property bool $is_ads_disabled_always
 * @property bool $is_orders_public
 * @property bool $is_notification_enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|VkUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VkUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VkUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|VkUser whereAdsDisabledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkUser whereIsAdsDisabledAlways($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkUser whereIsNotificationEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkUser whereIsOrdersPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkUser whereLvl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkUser whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Achievement> $achievements
 * @property-read int|null $achievements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserOrder> $orders
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserOrder> $completedOrders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Restaurant> $favouriteRestaurants
 * @property-read int|null $favourite_restaurants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DonateOrder> $donateOrders
 * @property-read int|null $donate_orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserNotification> $unreadNotifications
 * @property-read int|null $unread_notifications_count
 * @property bool $is_vk_pay_enabled
 * @property bool $is_donates_enabled
 * @method static \Illuminate\Database\Eloquent\Builder|VkUser whereIsDonatesEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VkUser whereIsVkPayEnabled($value)
 * @mixin \Eloquent
 */
class VkUser extends Model implements Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'id'
    ];

    protected $casts = [
        'ads_disabled_at'         => 'datetime',
        'is_ads_disabled_always'  => 'boolean',
        'is_orders_public'        => 'boolean',
        'is_notification_enabled' => 'boolean',
        'is_vk_pay_enabled'       => 'boolean',
        'is_donates_enabled'      => 'boolean',
    ];

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthPassword()
    {
        return '';
    }

    public function getRememberToken()
    {
        return '';
    }

    public function setRememberToken($value)
    {
    }

    public function getRememberTokenName()
    {
        return '';
    }

    public function isAdsEnabled(): bool
    {
        $order = $this->lastDonateOrder();
        if ($order === null) {
            return true;
        }

        if ($order->active_to === null) {
            return !($order->status === 'payed');
        }

        if ($order->type === 'active' && $order->active_to >= Carbon::now()) {
            return false;
        }

        return true;
    }

    public function isSubscriptionEnabled(): bool
    {
        $order = $this->lastDonateOrder();
        if ($order === null) {
            return false;
        }

        if ($order->active_to >= Carbon::now() && $order->status === 'payed') {
            return true;
        }

        return false;
    }

    public function getAdsDisableUntil(): ?string
    {
        $order = $this->lastDonateOrder();
        if ($order === null || null === $order->active_to || $order->active_to < Carbon::now() || $order->type !== 'active') {
            return null;
        }

        return $order->active_to->format(DATE_ATOM);
    }

    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements', 'vk_user_id', 'achievement_id');
    }

    public function favouriteRestaurants(): BelongsToMany
    {
        return $this->belongsToMany(Restaurant::class, 'user_favourites', 'vk_user_id', 'restaurant_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(UserNotification::class, 'vk_user_id');
    }

    public function unreadNotifications(): HasMany
    {
        return $this->hasMany(UserNotification::class, 'vk_user_id')->whereIsViewed(false);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(UserOrder::class, 'vk_user_id');
    }

    public function completedOrders(): HasMany
    {
        return $this->hasMany(UserOrder::class, 'vk_user_id')
            ->where('status', UserOrderStatusEnum::COMPLETED);
    }

    public function donateOrders(): HasMany
    {
        return $this->hasMany(DonateOrder::class, 'vk_user_id');
    }

    public function lastDonateOrder(): ?DonateOrder
    {
        return $this->donateOrders()->orderByDesc('id')->first();
    }

    public function getCompatibility(): int
    {
        return $this->id % 43 * 2; // only for demo app logic
    }
}
