<?php

namespace App\Integrations\VK\VkPay;

/**
 * Модуль 7. Монетизация, Урок 7. Продажа цифровых и физических товаров: реализация #M7L7
 * Статус возврата средств vk pay
 */
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
