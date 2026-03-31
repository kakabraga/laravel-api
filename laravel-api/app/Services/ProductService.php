<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\DTOs\Product\ProductDTO;
class ProductService
{

    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {
    }

    public function create(ProductDTO $dados) {
        $product = $this->productRepository->create([
            'name' => $dados->name,
            'quantity' => $dados->quantity,
            'weight' => $dados->weight,
            'price' => $dados->price,
        ]);
        
        return $product;
    }
}