<?php

declare(strict_types=1);

namespace App\Components\Notification;

use App\Events\NotificationCreated;
use App\Models\UserNotification;

/**
 * Модуль 4. Разработка, Урок 9. Уведомления #M4L13
 * Сервис по работе с уведомлениями пользователей
 */
final class NotificationService
{
    public function create(UserNotification $notification): void
    {
        $notification->save();

        event(new NotificationCreated($notification));
    }
}
