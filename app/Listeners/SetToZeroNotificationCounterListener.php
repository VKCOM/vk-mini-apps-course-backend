<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\NotificationViewed;
use App\Integrations\VK\Counter\ApiClient;

final class SetToZeroNotificationCounterListener
{
    public function __construct(private readonly ApiClient $apiService)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(NotificationViewed $event): void
    {
        $vk_user_id = $event->getVkUser()->id;

        $this->apiService->setCounter($vk_user_id, 0);
    }
}
