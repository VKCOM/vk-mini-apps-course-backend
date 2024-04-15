<?php

namespace App\Http\Resources;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RestaurantResource extends JsonResource
{
    public function __construct(
        private readonly Restaurant $restaurant
    ) {
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $restaurant = $this->restaurant;
        return [
            'id' => $restaurant->id,
            'group_id' => $restaurant->vk_group_id,
            'name' => $restaurant->name,
            'img' => Storage::disk('public')->url($restaurant->img),
            'description' => $restaurant->description,
            'link' => $restaurant->link,
            'cords' => [
                'lng' => $restaurant->cords_lng,
                'lat' => $restaurant->cords_lat,
            ],
            'rating' => $restaurant->rating,
        ];
    }
}
