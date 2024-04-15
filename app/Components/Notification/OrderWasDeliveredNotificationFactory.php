<?php

declare(strict_types=1);

namespace App\Components\Notification;

use App\Enums\UserNotificationActionTypeEnum;
use App\Enums\UserNotificationStatusEnum;
use App\Models\UserNotification;
use Carbon\Carbon;

use function Symfony\Component\String\s;

final class OrderWasDeliveredNotificationFactory
{
    private const TITLE = 'Заказ доставлен';
    private const TEXT = '#%s';
    private const ACTION_TITLE = 'Оценить заказ';

    public function create(int $orderId, int $vkUserId, string $image, ?string $shareImage = null): UserNotification
    {
        $notification = new UserNotification();
        $notification->img = $image;
        $notification->share_image = $shareImage;
        $notification->title = self::TITLE;
        $notification->text = sprintf(self::TEXT, str_pad((string)$orderId, 15, '0', STR_PAD_LEFT));
        $notification->action_title = self::ACTION_TITLE;
        $notification->action_type = UserNotificationActionTypeEnum::ORDER;
        $notification->status = UserNotificationStatusEnum::SUCCESS;
        $notification->date = Carbon::now();
        $notification->vk_user_id = $vkUserId;
        $notification->action_order_id = $orderId;

        return $notification;
    }
}
