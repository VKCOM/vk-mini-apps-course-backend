<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Enums\AchievementsCodeEnum;
use App\Enums\UserOrderStatusEnum;
use App\Events\AchievementReached;
use App\Events\OrderUpdated;
use App\Models\Achievement;
use App\Models\UserAchievement;
use App\Models\UserOrder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

final class CreateOrderAchievementListener
{
    public function handle(OrderUpdated $event): void
    {
        $order = $event->getOrder();

        if ($order->status !== UserOrderStatusEnum::COMPLETED) {
            return;
        }

        try {
            $achievement = $this->create($order);
        } catch (ModelNotFoundException $exception) {
            Log::error('Could not create achievement. Achievement not found', [
                'exception' => $exception->getMessage(),
            ]);
            return;
        }

        if ($achievement === null) {
            return;
        }

        event(new AchievementReached($achievement));

        try {
            $achievement->save();
        } catch (\Throwable $exception) {
            Log::error('Could not create achievement', [
                'exception' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * @throw ModelNotFoundException
     */
    private function create(UserOrder $order): ?UserAchievement
    {
        switch ($order->user->completedOrders()->count()) {
            case 1:
                $achievement = new UserAchievement();
                $achievement->vk_user_id = $order->vk_user_id;
                $achievement->achievement_id = Achievement::whereCode(AchievementsCodeEnum::FIRST_ORDER)->firstOrFail()->id;

                break;
            case 5:
                $achievement = new UserAchievement();
                $achievement->vk_user_id = $order->vk_user_id;
                $achievement->achievement_id = Achievement::whereCode(AchievementsCodeEnum::ORDERS_5)->firstOrFail()->id;

                break;

            case 8:
                $achievement = new UserAchievement();
                $achievement->vk_user_id = $order->vk_user_id;
                $achievement->achievement_id = Achievement::whereCode(AchievementsCodeEnum::ORDERS_8)->firstOrFail()->id;
                break;

            default:
                return null;
        }

        return $achievement;
    }
}
