<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Components\Notification\AchievementReachedNotificationFactory;
use App\Components\Notification\NotificationService;
use App\Enums\AchievementsCodeEnum;
use App\Enums\UserOrderStatusEnum;
use App\Events\OrderUpdated;
use App\Models\Achievement;

/**
 * Модуль 4. Разработка, Урок 9. Уведомления #M4L13
 * Обработчик события выдачи достижения за первый заказ в приложении
 */
final class CreateFirstOrderAchievementListener
{
    public function __construct(
        private readonly AchievementReachedNotificationFactory $achievementReachedNotificationFactory,
        private readonly NotificationService $notificationService
    ) {
    }

    public function handle(OrderUpdated $event): void
    {
        $order = $event->getOrder();

        if ($order->status !== UserOrderStatusEnum::CREATING || $order->user->completedOrders()->count() !== 1) {
            return;
        }

        $achievement = Achievement::whereCode(AchievementsCodeEnum::FIRST_ORDER)->first();

        $notification = $this->achievementReachedNotificationFactory->create(
            vkUserId: $order->vk_user_id,
            title: 'Новое достижение!',
            description: 'Поздравляем, вы сделали первый заказ!',
            image: $achievement?->img ?: $order->dish->small_img,
            shareImage: $achievement?->story_img,
        );

        $this->notificationService->create($notification);
    }
}
