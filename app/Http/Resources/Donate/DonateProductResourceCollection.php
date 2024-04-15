<?php

namespace App\Http\Resources\Donate;

use App\Models\DonateItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class DonateProductResourceCollection extends ResourceCollection
{
    public function __construct(private readonly Collection $donateItemsCollection)
    {
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->donateItemsCollection->map(
            fn (DonateItem $donateItem): array => (new DonateProductResource(
                code: $donateItem->code,
                period: $donateItem->period,
            ))->toArray($request)
        )->toArray();
    }
}
