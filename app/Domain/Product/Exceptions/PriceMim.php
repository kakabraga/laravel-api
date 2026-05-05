<?php
namespace App\Domain\Product\Exceptions;

class PriceLimitExceededException extends ProductException
{
    public function __construct()
    {
        parent::__construct('Price beyond the maximum allowed.', 422);
    }
}