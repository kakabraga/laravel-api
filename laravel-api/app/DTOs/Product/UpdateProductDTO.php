<?php

namespace App\DTOs\Product;

class UpdateProductDTO
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?int $quantity,
        public readonly ?float $weight,
        public readonly ?float $price,
    ) {
    }
}
