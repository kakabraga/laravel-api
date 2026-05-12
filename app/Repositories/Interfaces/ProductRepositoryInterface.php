<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;
use App\Models\User;
use App\Domain\Product\DTOs\ProductFilterDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function create(array $data): Product;
    public function update(Product $product, array $data): Product;
    public function paginateWithFilters(ProductFilterDTO $filters, User $user): LengthAwarePaginator;
    public function delete(Product  $product): bool;
}