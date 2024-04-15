<?php

declare(strict_types=1);

namespace App\Dto;

final class DonateOrderInfo
{
    public function __construct(private readonly string $title, private readonly int $price, private readonly int $discount, private readonly string $itemId, private readonly int $expiration, private readonly ?int $period = null)
    {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDiscount(): int
    {
        return $this->discount;
    }

    public function getItemId(): string
    {
        return $this->itemId;
    }

    public function getExpiration(): int
    {
        return $this->expiration;
    }

    public function getPeriod(): ?int
    {
        return $this->period;
    }
}
