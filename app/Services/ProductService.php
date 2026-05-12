<?php

namespace App\Services;

use Illuminate\Pipeline\Pipeline;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Domain\Product\Contexts\ProductContext;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Domain\Product\Rules\ValidatePriceRule;
use App\Domain\Product\Rules\ValidateQuantityRule;
use App\Domain\Product\DTOs\ProductDTO;
use App\Domain\Product\DTOs\UpdateProductDTO;
use App\Domain\Product\DTOs\ProductFilterDTO;
use App\Models\Product;
use App\Models\User;


class ProductService
{

    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private Pipeline $pipeline
    ) {
    }

    public function create(ProductDTO $data, User $user): Product
    {
        $this->runPipeline($data, $user);
        return $this->productRepository->create([...$data->toArray(), 'user_id' => $user->id]);
    }

    public function update(Product $product, UpdateProductDTO $updateProductDTO, User $user): Product
    {
        $this->runPipeline($updateProductDTO, $user);
        return $this->productRepository->update($product, $updateProductDTO->toArray());
    }

    public function delete(Product $product): bool
    {
        return $this->productRepository->delete($product);
    }

    private function runPipeline(
        ProductDTO|UpdateProductDTO $data,
        User $user,
        ?Product $product = null
    ): void {
        $this->pipeline
            ->send(new ProductContext($product, $data, $user))
            ->through([
                ValidatePriceRule::class,
                ValidateQuantityRule::class,
            ])
            ->thenReturn();
    }

    public function list(array $filters, User $user): LengthAwarePaginator
    {
        return $this->productRepository->paginateWithFilters(
            ProductFilterDTO::fromArray($filters),
            $user
        );
    }
}