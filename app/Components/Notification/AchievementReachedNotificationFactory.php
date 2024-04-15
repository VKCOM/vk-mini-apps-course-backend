<?php

declare(strict_types=1);

namespace App\Components\Notification;

use App\Enums\UserNotificationActionTypeEnum;
use App\Enums\UserNotificationStatusEnum;
use App\Models\UserNotification;
use Carbon\Carbon;

final class AchievementReachedNotificationFactory
{
    private const ACTION_TITLE = 'Поделиться';
    public function create(int $vkUserId, string $title, string $description, string $image, ?string $shareImage = null): UserNotification
    {
        $notification = new UserNotification();
        $notification->img = $image;
        $notification->share_image = $shareImage;
        $notification->title = $title;
        $notification->text = $description;
        $notification->action_title = self::ACTION_TITLE;
        $notification->action_type = UserNotificationActionTypeEnum::SHARE;
        $notification->status = UserNotificationStatusEnum::NONE;
        $notification->date = Carbon::now();
        $notification->vk_user_id = $vkUserId;

        return $notification;
    }
}
