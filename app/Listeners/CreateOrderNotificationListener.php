<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Components\Notification\NotificationService;
use App\Components\Notification\OrderWasCanceledNotificationFactory;
use App\Components\Notification\OrderWasDeliveredNotificationFactory;
use App\Enums\UserOrderStatusEnum;
use App\Events\OrderUpdated;

/**
 * Модуль 4. Разработка, Урок 9. Уведомления #M4L13
 * Обработчик событий отмены или заверения доставки заказа
 */
final class CreateOrderNotificationListener
{
    public function __construct(
        private readonly OrderWasDeliveredNotificationFactory $deliveredNotificationFactory,
        private readonly OrderWasCanceledNotificationFactory $canceledNotificationFactory,
        private readonly NotificationService $notificationService,
    ) {
    }

    public function handle(OrderUpdated $event): void
    {
        $order = $event->getOrder();

        $notification = match ($order->status) {
            UserOrderStatusEnum::COMPLETED => $this->deliveredNotificationFactory->create(
                orderId: $order->id,
                vkUserId: $order->vk_user_id,
                image: $order->dish->small_img,
                shareImage: $order->dish->full_img,
            ),
            UserOrderStatusEnum::CANCELED => $this->canceledNotificationFactory->create(
                orderId: $order->id,
                vkUserId: $order->vk_user_id,
                image: $order->dish->small_img,
            ),
            default => null,
        };

        if ($notification === null) {
            return;
        }

        $this->notificationService->create($notification);
    }
}
