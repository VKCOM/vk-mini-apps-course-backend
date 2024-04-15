<?php

namespace App\Http\Resources;

use App\Models\Achievement;
use App\Models\VkUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function __construct(
        private readonly VkUser $user
    ) {
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this->user;
        return [
            'id' => $user->id,
            'lvl' => $user->lvl,
            'orders_count' => $user->orders_count ?: $user->completedOrders()->count(),
            'compatibility' => $user->getCompatibility(),
            'is_orders_public' => $user->is_orders_public,
        ];
    }
}
