<?php

declare(strict_types=1);

namespace App\Dto;

/**
 * Модуль 7. Монетизация, Урок 7. Продажа цифровых и физических товаров: реализация #M7L7
 * Data Transfer Object: оплата заказа через vk pay
 */
final class VkPayOrder
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

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getMerchantData(): string
    {
        return $this->merchantData;
    }

    public function getMerchantSigne(): string
    {
        return $this->merchantSigne;
    }

    public function getTs(): int
    {
        return $this->ts;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getMerchantId(): int
    {
        return $this->merchantId;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function getSign(): string
    {
        return $this->sign;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }
}
