<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\NotificationViewed;
use App\Integrations\VK\Counter\ApiClient;

/**
 * Модуль 4. Разработка, Урок 18. Счётчики и бейджи #M4L18
 * Обработчик события все уведомления просмотрены
 */
final class SetToZeroNotificationCounterListener
{
    public function __construct(private readonly ApiClient $apiService)
    {
    }

    public function handle(NotificationViewed $event): void
    {
        $vk_user_id = $event->getVkUser()->id;

        $this->apiService->setCounter($vk_user_id, 0);
    }
}
