<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Components\Notification\NotificationService;
use App\Components\Notification\OrderWasCanceledNotificationFactory;
use App\Events\OrderCanceled;

final class CreateOrderCanceledNotificationListener
{
    public function __construct(
        private readonly OrderWasCanceledNotificationFactory $canceledNotificationFactory,
        private readonly NotificationService $notificationService,
    ) {
    }

    public function handle(OrderCanceled $event): void
    {
        $notification = $this->canceledNotificationFactory->create(
            orderId: $event->getOrder()->id,
            vkUserId: $event->getOrder()->vk_user_id,
            image: $event->getOrder()->dish->small_img,
        );

        $this->notificationService->create($notification);
    }
}
