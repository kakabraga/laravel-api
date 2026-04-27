<?php
namespace App\Domain\Product\Exceptions;

class InsufficientStockException extends ProductException
{
    public function __construct(int $available)
    {
        parent::__construct("Estoque insuficiente. Disponível: {$available}");
    }
}