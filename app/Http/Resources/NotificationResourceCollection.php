<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class NotificationResourceCollection extends ResourceCollection
{
    public function __construct(
        private readonly Collection $items
    ) {
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): Collection
    {
        return $this->items->map(
            fn ($item): array => (new NotificationResource($item))->toArray($request)
        );
    }
}
