<?php

namespace App\Http\Resources\Donate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonateProductResource extends JsonResource
{
    public function __construct(private readonly string $code, private readonly ?int $period)
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
            'code' => $this->code,
            'period' => $this->period
        ];
    }
}
