<?php

namespace App\Http\Resources;

use App\Models\Dish;
use App\Models\Restaurant;
use App\Models\VkUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class DishResource extends JsonResource
{
    public function __construct(
        private readonly Dish $dish,
        private readonly ?VkUser $user = null
    ) {
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $dish = $this->dish;
        $isFavourite = null;
        if ($this->user instanceof \App\Models\VkUser) {
            $isFavourite = Arr::first($this->user->favouriteRestaurants, fn (Restaurant $value): bool => $value->id === $dish->restaurant->id) !== null;
        }
        return [
            'id' => $dish->id,
            'small_img' => Storage::disk('public')->url($dish->small_img),
            'full_img' => Storage::disk('public')->url($dish->full_img),
            'name' => $dish->name,
            'description' => $dish->description,
            'restaurant' => (new RestaurantResource($dish->restaurant))->toArray($request),
            'price' => $dish->price,
            'bonus' => $dish->bonus,
            'is_favourite' => $isFavourite,
            'dish_options' => $dish->dish_options,
            'extra_options' => $dish->extra_options,
        ];
    }
}
