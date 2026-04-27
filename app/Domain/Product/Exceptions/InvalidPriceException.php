<?php
namespace App\Domain\Product\Exceptions;

class InvalidPriceException extends ProductException
{
    public function __construct()
    {
        parent::__construct("Invalid price.", 422);
    }
}