<?php

namespace App\Dto;

class ExtraDishOption
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
    ) {
    }
}
