<?php

namespace App\Integrations\VK\VkPay;

final class ReverseStatusResponse
{
    public function __construct(
        private readonly string $transactionId,
        private readonly TransactionStatusEnum $status,
        private readonly TransactionActionEnum $transactionAction,
        private readonly array $rawData,
    ) {
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function getStatus(): TransactionStatusEnum
    {
        return $this->status;
    }

    public function getTransactionAction(): TransactionActionEnum
    {
        return $this->transactionAction;
    }

    public function getRawData(): array
    {
        return $this->rawData;
    }
}
