<?php

namespace App\Listeners;

use App\Components\Notification\AchievementReachedNotificationFactory;
use App\Components\Notification\NotificationService;
use App\Enums\AchievementsCodeEnum;
use App\Events\AchievementReached;

/**
 * Модуль 4. Разработка, Урок 9. Уведомления #M4L13
 * Обработчик события выдачи достижений при добавлении в избранное ресторана, завершении 5 заказов или 8 заказов.
 */
final class CreateNotificationWhenAchievementReachedListener
{
    public function __construct(
        private readonly AchievementReachedNotificationFactory $achievementReachedNotificationFactory,
        private readonly NotificationService $notificationService
    )
    {
    }

    public function handle(AchievementReached $event): void
    {
        $userAchievement = $event->getAchievement();

        $achievement = $userAchievement->achievement;
        $description = match ($achievement->code) {
            AchievementsCodeEnum::FAVOURITE => 'Вы добавили ресторан в избранное!',
            AchievementsCodeEnum::ORDERS_5 => 'Ура! Вы сделали 5 заказов!',
            AchievementsCodeEnum::ORDERS_8 => 'Ура! Вы сделали 8 заказов!',
            default => $achievement->title,
        };


        $notification = $this->achievementReachedNotificationFactory->create(
            vkUserId: $userAchievement->vk_user_id,
            title: 'Новое достижение!',
            description: $description,
            image: $achievement->img,
            shareImage: $achievement->story_img,
        );

        $this->notificationService->create($notification);
    }
}
