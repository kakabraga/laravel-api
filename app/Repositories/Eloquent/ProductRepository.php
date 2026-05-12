<?php

namespace App\Repositories\Eloquent;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Domain\Product\DTOs\ProductFilterDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Product;
use App\Models\User;

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
    public function findById(int $id_product): ?Product
    {
        return Product::find($id_product);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    public function paginateWithFilters(ProductFilterDTO $filters, User $user): LengthAwarePaginator
    {
        return Product::query()
            ->where('user_id', $user->id)
            ->orderBy($filters->sort, $filters->order)
            ->paginate($filters->perPage);
    }

}