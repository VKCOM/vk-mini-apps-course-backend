<?php

declare(strict_types=1);

namespace App\Http\Resources\Donate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonateSuccessOrderResource extends JsonResource
{
    public function __construct(private readonly int $orderId, private readonly int $appOrderId)
    {
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_id' => $this->orderId,
            'app_order_id' => $this->appOrderId,
        ];
    }
}
