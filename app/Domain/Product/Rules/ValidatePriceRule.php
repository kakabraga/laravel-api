<?php

namespace App\Domain\Product\Rules;
use App\Domain\Product\DTOs\ProductDTO;
use App\Domain\Product\Exceptions\PriceLimitExceededException;
use App\Domain\Product\Exceptions\InvalidPriceException;

class ValidatePriceRule
{
    public function validate(
        ProductDTO $dto
    ): void {
        if ($dto->price <= 0) {
            throw new InvalidPriceException();
        }

        if ($dto->price > config('product.price.max')) {
            throw new PriceLimitExceededException();
        }
    }
}