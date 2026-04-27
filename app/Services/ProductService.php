<?php

namespace App\Services;

use App\Exceptions\BusinessException;
use App\Exceptions\Product\QuantityLimitExceededException;
use App\Exceptions\Product\ProductLimitExceededException;
use App\Exceptions\Product\PriceLimitExceededException;
use App\Models\User;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Domain\Product\Validators\CreateProductValidator;
use App\Domain\Product\DTOs\ProductDTO;
use App\DTOs\Product\UpdateProductDTO;
use App\Models\Product;


class ProductService
{

    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private CreateProductValidator $createProductValidator,
    ) {
    }

    public function create(ProductDTO $dados, User $user)
    {

        $this->createProductValidator->validate($dados, $user);

        $product = $this->productRepository->create([
            'name' => $dados->name,
            'quantity' => $dados->quantity,
            'weight' => $dados->weight,
            'price' => $dados->price,
            'user_id' => $user->id
        ]);

        return $product;
    }

    public function paginate(int $perPage)
    {
        return $this->productRepository->paginate($perPage);
    }

    public function list($filters, int $userId)
    {
        $perPage = $filters['per_page'] ?? 10;

        $perPage = max(1, min((int) $perPage, 50));

        $sort = $filters['sort'] ?? 'created_at';
        $order = $filters['order'] ?? 'desc';

        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'desc';
        }

        $allowedSorts = ['name', 'price', 'quantity', 'created_at'];

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }

        $filters['sort'] = $sort;
        $filters['order'] = $order;

        return $this->productRepository->paginateWithFilters($filters, $perPage, $userId);
    }


    public function update(Product $product, UpdateProductDTO $data)
    {

        return $this->productRepository->update(
            $product,
            array_filter([
                'name' => $data->name,
                'quantity' => $data->quantity,
                'weight' => $data->weight,
                'price' => $data->price,
            ], fn($value) => !is_null($value))
        );
    }

    public function delete(Product $product)
    {
        return $this->productRepository->delete($product);
    }

}