<?php

namespace App\Domain\Product\DTOs;
use App\Models\User;
class ProductDTO
{
    public function __construct(
        public readonly string $name,
        public readonly int $quantity,
        public readonly float $weight,
        public readonly float $price,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            quantity: $data['quantity'],
            weight: $data['weight'],
            price: $data['price'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'quantity' => $this->quantity,
            'weight' => $this->weight,
            'price' => $this->price,
        ];
    }
}
