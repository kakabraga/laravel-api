<?php 
namespace App\Exceptions\Product;

class ProductLimitExceededException extends ProductException
{
    public function __construct()
    {
        parent::__construct('Limit of 10,000 products per user reached.', 422);
    }
}