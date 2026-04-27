<?php

namespace App\Domain\Product\Validators;

use App\Domain\Product\DTOs\ProductDTO;
use App\Models\User;
use App\Domain\Product\Rules\ValidatePriceRule;
use App\Domain\Product\Rules\ProductLimitRule;
use App\Domain\Product\Rules\UniqueProductRule;

class CreateProductValidator
{
    public function __construct(
        private ValidatePriceRule $priceRule,
        // private ProductLimitRule $limitRule,
        // private UniqueProductRule $uniqueRule,
    ) {}

    public function validate(ProductDTO $dto, User $user): void
    {
        $this->priceRule->validate($dto);
        // $this->limitRule->validate($user);
        // $this->uniqueRule->validate($dto, $user);
    }
}
