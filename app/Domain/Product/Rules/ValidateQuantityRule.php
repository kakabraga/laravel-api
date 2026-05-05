<?php 
namespace App\Domain\Product\Rules;

use App\Domain\Product\Exceptions\QuantityLimitExceededException;
use App\Domain\Product\Contexts\ProductCreationContext;
use Closure;
class ValidateQuantityRule {

    public function handle(ProductCreationContext $context, Closure $next) : mixed {
        if($context->dto->quantity > config('product.limits.max_products_per_user')) {
            throw new QuantityLimitExceededException();
        }

        return $next($context);
    }

}