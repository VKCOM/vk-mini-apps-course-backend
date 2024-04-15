<?php

namespace App\Dto;

class DishOption
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly float $price,
    ) {
    }
}
