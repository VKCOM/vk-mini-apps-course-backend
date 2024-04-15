<?php

namespace App\Http\Resources;

use App\Models\Achievement;
use App\Models\VkUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class UserSelfResource extends JsonResource
{
    public function __construct(
        private readonly VkUser $user,
    ) {
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $allAchievements = Cache::remember(Achievement::ALL_ACHIEVEMENTS_LIST, 60 * 60, static fn () => Achievement::all());
        $user = $this->user;
        return [
            'id' => $user->id,
            'lvl' => $user->lvl,
            'orders_count' => $user->orders_count ?: $user->completedOrders()->count(),
            'compatibility' => $user->getCompatibility(),
            'is_orders_public' => $user->is_orders_public,
            'is_ads_enabled' => $user->isAdsEnabled(),
            'is_subscription_enabled' => $user->isSubscriptionEnabled(),
            'ads_disabled_until' => $user->getAdsDisableUntil(),
            'is_notification_enabled' => $user->is_notification_enabled,
            'notifications_count' => $user->notifications_count ?? $user->unreadNotifications()->count(),
            'is_vk_pay_enabled' => $user->is_vk_pay_enabled,
            'is_donates_enabled' => $user->is_donates_enabled,
            'achievements' => (new AchievementResourceCollection(
                $allAchievements,
                $user->achievements
            ))->toArray($request),
        ];
    }
}
