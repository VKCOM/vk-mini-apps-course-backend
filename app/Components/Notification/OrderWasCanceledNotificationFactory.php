<?php

declare(strict_types=1);

namespace App\Components\Notification;

use App\Enums\UserNotificationActionTypeEnum;
use App\Enums\UserNotificationStatusEnum;
use App\Models\UserNotification;
use Carbon\Carbon;

/**
 * Модуль 4. Разработка, Урок 9. Уведомления #M4L13
 * Фабрика для создания уведомления об отмене заказа
 */
final class OrderWasCanceledNotificationFactory
{
    private const TITLE = 'Заказ не доставлен';
    private const TEXT = '#%s';
    private const ACTION_TITLE = 'Написать в поддержку';
    public function create(int $orderId, int $vkUserId, string $image): UserNotification
    {
        $notification = new UserNotification();
        $notification->img = $image;
        $notification->title = self::TITLE;
        $notification->text = sprintf(self::TEXT, str_pad((string)$orderId, 15, '0', STR_PAD_LEFT));
        $notification->action_title = self::ACTION_TITLE;
        $notification->action_type = UserNotificationActionTypeEnum::ORDER;
        $notification->status = UserNotificationStatusEnum::FAILED;
        $notification->date = Carbon::now();
        $notification->vk_user_id = $vkUserId;
        $notification->action_order_id = $orderId;

        return $notification;
    }
}
