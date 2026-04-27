<?php
namespace App\Exceptions\Product;

use Exception;

abstract class ProductException extends Exception
{
    public function __construct(string $message, protected int $statusCode = 422)
    {
        parent::__construct($message);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}