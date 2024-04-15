<?php

namespace App\Http\Resources;

use App\Models\UserOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function __construct(
        private readonly UserOrder $order,
        private readonly int $viewerId
    ) {
    }

    protected function isNeedShowFullInfo(): bool
    {
        return $this->viewerId === $this->order->vk_user_id;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $order = $this->order;

        if (!$this->isNeedShowFullInfo()) {

            return [
                'id' => $order->id,
                'dish' => (new DishResource($order->dish, $order->user))->toArray($request),
                'extra_options' => null,
                'dish_options' => null,
                'delivery_address' => null,
                'discount' => $order->discount ?? 0,
                'delivery_price' => $order->delivery_price ?? 0,
                'status' => $order->status->value,
                'delivery_time' => null,
                'date' => $order->created_at,
                'price' => $order->total_price,
                'rating' => null,
            ];
        }

        $delivery_address = null;
        if ($order->delivery_address) {
            $delivery_address = [
                'city' => $order->delivery_address->city,
                'street' => $order->delivery_address->street,
                'house' => $order->delivery_address->house,
                'apartment' => $order->delivery_address->apartment,
                'entrance' => $order->delivery_address->entrance,
                'floor' => $order->delivery_address->floor,
                'comment' => $order->delivery_address->comment,
            ];
        }
        $delivery_time = 0;
        $now = Carbon::now();
        if ($order->delivery_planned_at && $now < $order->delivery_planned_at) {
            $delivery_time = $order->delivery_planned_at->diff(Carbon::now())->m;
        }

        return [
            'id' => $order->id,
            'dish' => (new DishResource($order->dish, $order->user))->toArray($request),
            'extra_options' => $order->extra_options,
            'dish_options' => $order->dish_options,
            'delivery_address' => $delivery_address,
            'discount' => $order->discount ?? 0,
            'delivery_price' => $order->delivery_price ?? 0,
            'status' => $order->status->value,
            'delivery_time' => $delivery_time,
            'date' => $order->created_at,
            'price' => $order->total_price,
            'rating' => $order->rate,
        ];
    }
}
