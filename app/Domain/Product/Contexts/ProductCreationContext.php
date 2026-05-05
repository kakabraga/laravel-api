<?php
namespace App\Domain\Product\Contexts;

use App\Domain\Product\DTOs\ProductDTO;
use App\Models\User;

class ProductCreationContext
{
    public function __construct(
        public readonly ProductDTO $dto,
        public readonly User $user,
    ) {
    }
}