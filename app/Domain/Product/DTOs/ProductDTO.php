<?php

namespace App\Domain\Product\DTOs;

class ProductDTO
{
    public function __construct(
        public readonly string $name,
        public readonly int $quantity,
        public readonly float $weight,
        public readonly float $price,
    ) {
    }
}
