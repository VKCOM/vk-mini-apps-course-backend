<?php

namespace App\Events;

use App\Models\UserNotification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

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
