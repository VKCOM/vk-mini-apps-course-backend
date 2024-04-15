<?php

declare(strict_types=1);

namespace App\Http\Resources\Donate;

use App\Dto\DonateOrderInfo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonateItemResource extends JsonResource
{
    public function __construct(private readonly DonateOrderInfo $orderInfo)
    {
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $result = [
            'title' => $this->orderInfo->getTitle(),
            'price' => $this->orderInfo->getPrice(),
            'discount' => $this->orderInfo->getDiscount(),
            'item_id' => $this->orderInfo->getItemId(),
            'expiration' => $this->orderInfo->getExpiration(),
        ];

        if ($this->orderInfo->getPeriod() !== null) {
            $result['period'] = $this->orderInfo->getPeriod();
        }

        return $result;
    }
}
