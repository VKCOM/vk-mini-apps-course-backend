<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResourceCollection;
use App\Models\UserNotification;
use App\Models\VkUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getUserNotifications(VkUser $vkUser): NotificationResourceCollection
    {
        $authUserId = Auth::id();
        if ($vkUser->id !== $authUserId) {
            abort(403);
        }

        return new NotificationResourceCollection(
            $vkUser->notifications()->get(),
        );
    }

    public function setNotifications(VkUser $vkUser): JsonResponse
    {
        $authUserId = Auth::id();
        if ($vkUser->id !== $authUserId) {
            abort(403);
        }

        $vkUser->is_notification_enabled = !$vkUser->is_notification_enabled;
        $result = $vkUser->save();

        return response()->json(['data' => $result]);
    }

    public function markNotificationsAsViewed(VkUser $vkUser): JsonResponse
    {
        $authUserId = Auth::id();
        if ($vkUser->id !== $authUserId) {
            abort(403);
        }

        $notifications = $vkUser->unreadNotifications();

        $result = $notifications
            ->update(['is_viewed' => true])
        ;

        return response()->json(['data' => $result]);
    }
}
