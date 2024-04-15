<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class AchievementResourceCollection extends ResourceCollection
{
    public function __construct(
        private readonly Collection $allItems,
        private readonly Collection $userItems,
    ) {
    }
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->allItems->map(
            fn ($item): array => (new AchievementResource(
                $item,
                !$this->userItems->where('id', '=', $item->id)->isEmpty()
            )
            )->toArray($request)
        )->toArray();
    }
}
