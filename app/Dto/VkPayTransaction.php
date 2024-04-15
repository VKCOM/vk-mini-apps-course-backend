<?php

declare(strict_types=1);

namespace App\Dto;

use App\Enums\VkPayCallbackStatusEnum;

final class VkPayTransaction
{
    public function __construct(
        private readonly string $transactionId,
        private readonly string $notificationType,
        private readonly float $amount,
        private readonly VkPayCallbackStatusEnum $status,
        private readonly string $transactionUuid,
        private readonly array $rawData
    ) {
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function getNotificationType(): string
    {
        return $this->notificationType;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getStatus(): VkPayCallbackStatusEnum
    {
        return $this->status;
    }

    public function getRawData(): array
    {
        return $this->rawData;
    }

    public function getTransactionUuid(): string
    {
        return $this->transactionUuid;
    }
}
