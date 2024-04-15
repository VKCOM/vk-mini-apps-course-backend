<?php

declare(strict_types=1);

namespace App\Components\Notification;

use App\Events\NotificationCreated;
use App\Models\UserNotification;

final class NotificationService
{
    public function create(UserNotification $notification): void
    {
        $notification->save();

        event(new NotificationCreated($notification));
    }
}
