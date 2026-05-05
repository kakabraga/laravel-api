<?php
namespace App\Domain\Product\Exceptions;

class InvalidPriceException extends ProductException
{
    public function __construct(string $message = "Invalid price.")
    {
        parent::__construct($message, 422);
    }
}
