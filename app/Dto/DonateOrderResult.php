<?php

declare(strict_types=1);

namespace App\Dto;

/**
 * Модуль 7. Монетизация, Урок 5. Продажа виртуальных ценностей: разовая оплата и подписки #M7L5
 * Data Transfer Object: результаты оплаты
 */
final class DonateOrderResult
{
    public function __construct(private readonly int $internalOrderId, private readonly int $externalOrderId)
    {
    }

    public function getInternalOrderId(): int
    {
        return $this->internalOrderId;
    }

    public function getExternalOrderId(): int
    {
        return $this->externalOrderId;
    }
}
