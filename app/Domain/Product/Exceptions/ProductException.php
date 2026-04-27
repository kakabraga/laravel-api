<?php
namespace App\Domain\Product\Exceptions;

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