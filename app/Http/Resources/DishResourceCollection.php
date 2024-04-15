<?php

namespace App\Http\Resources;

use App\Models\Dish;
use App\Models\VkUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class DishResourceCollection extends ResourceCollection
{
    public function __construct(
        private readonly Collection $dishes,
        private readonly ?VkUser $user = null,
    ) {
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): Collection
    {
        return $this->dishes->map(
            fn (Dish $d): array => (new DishResource($d, $this->user))->toArray($request)
        );
    }
}
