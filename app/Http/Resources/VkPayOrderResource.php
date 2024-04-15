<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VkPayOrderResource extends JsonResource
{
    public function __construct(
        private readonly float $amount,
        private readonly string $currency,
        private readonly string $merchantData,
        private readonly string $merchantSigne,
        private readonly int $ts,
        private readonly string $description,
        private readonly int $merchantId,
        private readonly int $version,
        private readonly string $sign,
        private readonly string $orderId,
    ) {
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'amount' => $this->amount,
                'description' => $this->description,
                'merchant_id' => $this->merchantId,
                'version' => $this->version,
                'sign' => $this->sign,
                'data' => [
                    'currency' => $this->currency,
                    'order_id' => $this->orderId,
                    'merchant_data' => $this->merchantData,
                    'merchant_sign' => $this->merchantSigne,
                    'ts' => $this->ts,
                ],
            ]
        ];
    }
}
