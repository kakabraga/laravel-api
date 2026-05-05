<?php

namespace App\Domain\Product\Rules;
use App\Domain\Product\Exceptions\PriceLimitExceededException;
use App\Domain\Product\Exceptions\InvalidPriceException;
use App\Domain\Product\Contexts\ProductCreationContext;
use Closure;
class ValidatePriceRule
{
    public function handle(
        ProductCreationContext $context,
        Closure $next
    ): mixed {
        if ($context->dto->price <= 0) {
            throw new InvalidPriceException();
        }

        if ($context->dto->price > config('product.price.max')) {
            throw new PriceLimitExceededException();
        }

        if ($context->dto->price < config('product.price.min')) {
            throw new PriceLimitExceededException();
        }

        if (round($context->dto->price, 2) != $context->dto->price) {
            throw new InvalidPriceException('Price must have at most 2 decimal places.');
        }
        return $next($context);
    }
}