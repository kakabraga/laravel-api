<?php

namespace App\Repositories\Eloquent;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{

    public function create(array $data): Product
    {
        return Product::create($data);
    }
}