<?php

declare(strict_types=1);

namespace App\Dto;

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
