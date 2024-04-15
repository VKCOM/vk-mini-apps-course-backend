<?php

declare(strict_types=1);

namespace App\Http\Resources\Donate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonateErrorResource extends JsonResource
{
    public function __construct(private readonly int $errorCode, private readonly string $message = '', private readonly bool $isCritical = false)
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
            'error_code' => $this->errorCode,
            'error_msg' => $this->message,
            'critical' => $this->isCritical,
        ];
    }
}
