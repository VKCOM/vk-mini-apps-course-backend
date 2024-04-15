<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\NotificationCreated;
use App\Integrations\VK\Counter\ApiClient;
use App\Models\VkUser;

final class IncreaseNotificationCounterListener
{
    public function __construct(private readonly ApiClient $apiService)
    {
    }

    public function handle(NotificationCreated $event): void
    {
        $vk_user_id = $event->getNotification()->vk_user_id;

        $count = VkUser::whereId($vk_user_id)->firstOrFail()->unreadNotifications()->count();

        $this->apiService->setCounter($vk_user_id, $count);
    }
}
