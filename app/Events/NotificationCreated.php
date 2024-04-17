<?php

namespace App\Events;

use App\Models\UserNotification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Модуль 4. Разработка, Урок 18. Счётчики и бейджи #M4L18
 * Event о создании уведомления пользователю, чтобы изменить значение счётчика
 */
class NotificationCreated
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(private UserNotification $notification)
    {
    }

    public function getNotification(): UserNotification
    {
        return $this->notification;
    }
}
