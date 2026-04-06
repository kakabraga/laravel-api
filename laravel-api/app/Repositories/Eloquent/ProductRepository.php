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
    public function findById(int $id_product): Product
    {

        return Product::findOrFail($id_product);

    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }

    public function delete(int $id_product): bool
    {
        $product = Product::findOrFail($id_product);
        return $product->delete();
    }

    public function paginateWithFilters(Array $filters, Int $perPage): LengthAwarePaginator
    {
        return Product::query()
            ->when(!empty($filters['search']), function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['search'] . '%');
            })

            ->when(isset($filters['min_price']), function ($query) use ($filters) {
                $query->where('price', '>=', $filters['min_price']);
            })

            ->when(isset($filters['max_price']), function ($query) use ($filters) {
                $query->where('price', '<=', $filters['max_price']);
            })

            ->orderBy($filters['sort'], $filters['order'])

            ->paginate($perPage);
    }
}