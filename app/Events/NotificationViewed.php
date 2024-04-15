<?php

namespace App\Events;

use App\Models\VkUser;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

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
