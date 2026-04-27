<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

use App\Services\ProductService;

use App\Domain\Product\DTOs\ProductDTO; 
use App\DTOs\Product\UpdateProductDTO;

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
        $userId = $request->user()->id;

        return ApiResponse::success(
            ProductResource::collection(
                $productService->list($request->all(), $userId)
            )
        );


    }

    public function store(StoreProductRequest $request, ProductService $productService)
    {
        $produtoDTO = new ProductDTO(
            name: $request->name,
            quantity: $request->quantity,
            weight: $request->weight,
            price: $request->price
        );

        return ApiResponse::success(
            new ProductResource(
                $productService->create($produtoDTO,$request->user())
            ),
            "Product created successfully.",
            201
        );
    }
    /**
     * Display the specified resource.
     */
    public function show(int $product, ProductService $productService)
    {
        $this->authorize('view', $product);
        return ApiResponse::success($product);
    }


    public function update(
        UpdateProductRequest $request,
        ProductService $productService,
        Product $product
    ) {

        $this->authorize('update', $product);

        $dto = new UpdateProductDTO(
            name: $request->name,
            quantity: $request->quantity,
            weight: $request->weight,
            price: $request->price,
        );

        $product = $productService->update($product, $dto);

        return ApiResponse::success(
            new ProductResource($product),
            "Updated"
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
