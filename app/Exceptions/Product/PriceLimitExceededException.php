<?php
namespace App\Exceptions\Product;

class PriceLimitExceededException extends ProductException
{
    public function __construct()
    {
        parent::__construct('Price beyond the maximum allowed.', 422);
    }
}