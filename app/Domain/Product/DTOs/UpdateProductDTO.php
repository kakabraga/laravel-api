<?php

namespace App\Domain\Product\DTOs;

class UpdateProductDTO
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?int $quantity,
        public readonly ?float $weight,
        public readonly ?float $price,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            quantity: $data['quantity'] ?? null,
            weight: $data['weight'] ?? null,
            price: $data['price'] ?? null,
        );
    }
}
