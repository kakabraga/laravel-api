<?php
namespace App\Exceptions\Product;

use App\Exceptions\Product\ProductException;


class QuantityLimitExceededException extends ProductException
{
    public function __construct()
    {
        parent::__construct('The maximum quantity per insertion is 1000 units.', 422);
    }
}