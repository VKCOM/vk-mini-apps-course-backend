<?php

namespace App\Http\Resources;

use App\Models\VkUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class UserRatingResourceCollection extends ResourceCollection
{
    public function __construct(
        private readonly Collection $items,
    ) {
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->items->map(
            fn (VkUser $item): array => (new UserResource($item))->toArray($request)
        )->toArray();
    }
}
