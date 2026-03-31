<?php

namespace App\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\DTOs\Product\ProductDTO;
use App\DTOs\Product\UpdateProductDTO;
use App\Models\Product;
class ProductService
{

    public function __construct(
        private ProductRepositoryInterface $productRepository
    ) {
    }

    public function create(ProductDTO $dados)
    {
        $product = $this->productRepository->create([
            'name' => $dados->name,
            'quantity' => $dados->quantity,
            'weight' => $dados->weight,
            'price' => $dados->price,
        ]);

        return $product;
    }

    public function paginate(int $perPage)
    {
        return $this->productRepository->paginate($perPage);
    }

    public function findById(int $id_product): Product
    {
        $product = $this->productRepository->findById($id_product);

        if (!$product) {
            throw new NotFoundHttpException('Produto não encontrado');
        }

        return $product;
    }
    public function update(int $id_product, UpdateProductDTO $data)
    {
        $product = $this->productRepository->findById($id_product);
        return $this->productRepository->update($product, array_filter([
            'name' => $data->name,
            'quantity' => $data->quantity,
            'weight' => $data->weight,
            'price' => $data->price,
        ], fn($value) => !is_null($value)));
    }

    public function delete(int $id_product)
    {

        return $this->productRepository->delete($id_product);
    }
}