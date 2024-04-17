<?php

namespace App\Events;

use App\Models\VkUser;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Модуль 4. Разработка, Урок 9. Уведомления #M4L13
 * Event о прочтении уведомления пользователем
 */
class NotificationViewed
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(private readonly VkUser $vkUser)
    {
    }

    public function getVkUser(): VkUser
    {
        return $this->vkUser;
    }
}
