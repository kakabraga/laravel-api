<?php

namespace App\Domain\Product\Rules;
use App\Domain\Product\Exceptions\PriceLimitExceededException;
use App\Domain\Product\Exceptions\InvalidPriceException;
use App\Domain\Product\Contexts\ProductContext;
use Closure;
class ValidatePriceRule
{
    public function handle(
        ProductContext $context,
        Closure $next
    ): mixed {
        
        $price = $context->dto->price;
        $min = config('product.price.min');
        $max = config('product.price.max');

        if ($price < $min || $price > $max) {
            throw new PriceLimitExceededException();
        }

        if (round($price, 2) !== (float) $price) {
            throw new InvalidPriceException('Price must have at most 2 decimal places.');
        }

        return $next($context);
    }
}