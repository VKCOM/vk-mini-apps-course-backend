<?php

namespace App\Http\Resources;

use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class NotificationResource extends JsonResource
{
    public function __construct(
        private readonly UserNotification $notification
    ) {
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $item = $this->notification;
        $action = null;
        if (isset($item->action_type)) {
            $action = [
                'type' => $item->action_type,
                'title' => $item->action_title,
                'order_id' => $item->action_order_id,
                'share_image' => $item->share_image ? Storage::disk('public')->url($item->share_image) : null,
            ];
        }

        return [
            'id' => $item->id,
            'is_viewed' => $item->is_viewed,
            'title' => $item->title,
            'text' => $item->text,
            'img' => Storage::disk('public')->url($item->img),
            'status' => $item->status,
            'date' => $item->created_at,
            'action' => $action,
        ];
    }
}
