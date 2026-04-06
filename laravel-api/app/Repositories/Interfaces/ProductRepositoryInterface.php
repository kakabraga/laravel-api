<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function create(array $data): Product;
    public function findById(int  $id_product): Product;
    public function paginate(int $perPage): LengthAwarePaginator;
    public function update(Product $product, array $data): Product;
    public function paginateWithFilters(Array $filters, int $perPage): LengthAwarePaginator;
    public function delete(int  $id_product): bool;
}