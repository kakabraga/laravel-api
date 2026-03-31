<?php

namespace App\Repositories\Eloquent;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Product::orderBy('created_at', 'desc')
            ->paginate($perPage);

    }
}