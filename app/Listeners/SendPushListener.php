<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\NotificationCreated;
use App\Integrations\VK\Push\ApiClient;
use App\Models\UserNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

final class SendPushListener
{
    public function __construct(
        private readonly ApiClient $pushService
    ) {
    }

    public function handle(NotificationCreated $event): void
    {
        $vkUserId = $event->getNotification()->vk_user_id;
        $notifications = UserNotification::whereVkUserId($vkUserId)
            ->where('created_at', '>=', Carbon::today()->startOfDay())
        ;

        if ($notifications->count() !== 1) {
            Log::error('Not first notification for user ' . $vkUserId);
            return;
        }

        $first = $notifications->orderBy('created_at', 'asc')->firstOrFail();
        if ($this->pushService->isNotificationAllowed($vkUserId)) {
            $success = $this->pushService->send($vkUserId, $first->title, "/profile/{$vkUserId}/notifications");

            if (!$success) {
                Log::info('Could not send push for user ' . $vkUserId);
            }
        }
    }
}
