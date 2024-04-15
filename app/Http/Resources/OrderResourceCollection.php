<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class OrderResourceCollection extends ResourceCollection
{
    public function __construct(
        private readonly Collection $items,
        private readonly int $viewerId
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
            fn ($item): array => (new OrderResource($item, $this->viewerId))->toArray($request)
        )->toArray();
    }
}
