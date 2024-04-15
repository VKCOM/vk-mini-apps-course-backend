<?php

namespace App\Dto;

class DeliveryAddress
{
    public function __construct(
        public readonly string $city,
        public readonly string $street,
        public readonly string $house,
        public readonly string $apartment,
        public readonly string $entrance,
        public readonly string $floor,
        public readonly string $comment,
    ) {
    }
}
