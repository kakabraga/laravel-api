<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

use App\Services\ProductService;

use App\Domain\Product\DTOs\UpdateProductDTO;
use App\Domain\Product\DTOs\ProductDTO;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


use App\Models\Product;
use Illuminate\Http\Request;

use App\Helpers\ApiResponse;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{

    use AuthorizesRequests;
    public function index(ProductService $productService, Request $request)
    {
        $this->authorize('viewAny', Product::class);
        $user = $request->user();
        return ApiResponse::success(
            ProductResource::collection(
                $productService->list($request->all(), $user)
            )
        );
    }

    public function store(StoreProductRequest $request, ProductService $productService)
    {
        $productDTO = ProductDTO::fromArray($request->validated());

        return ApiResponse::success(
            new ProductResource(
                $productService->create($productDTO, $request->user())
            ),
            "Product created successfully.",
            201
        );
    }
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $this->authorize('view', $product);
        return ApiResponse::success(
            new ProductResource($product)
        );
    }


    public function update(
        UpdateProductRequest $request,
        ProductService $productService,
        Product $product
    ) {

        $this->authorize('update', $product);
        $produtDTO = UpdateProductDTO::fromArray($request->validated());
        $user = $request->user();
        $product = $productService->update($product, $produtDTO, $user);

        return ApiResponse::success(
            new ProductResource($product),
            "Product Updated successfully."
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, ProductService $productService)
    {
        $this->authorize('delete', $product);

        $productService->delete($product);

        return response()->noContent();
    }
}
