<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VkPayResponseResource extends JsonResource
{
    public function __construct(private readonly string $transactionId, private readonly string $notificationType, private readonly int $merchanId)
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
            'body' => [
                'transaction_id' => $this->transactionId,
                'notify_type' => $this->notificationType,
            ],
            'header' => [
                'status' => 'OK',
                'ts' => Carbon::now()->timestamp,
                'client_id' => $this->merchanId,
            ],
        ];
    }
}
