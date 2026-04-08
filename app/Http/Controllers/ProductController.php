<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

use App\Services\ProductService;

use App\DTOs\Product\ProductDTO;
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
        $ProdutoDTO = new ProductDTO(
            name: $request->name,
            quantity: $request->quantity,
            weight: $request->weight,
            price: $request->price
        );
        $userId = $request->user()->id;

        return ApiResponse::success(
            new ProductResource(
                $productService->create($ProdutoDTO, $userId)
            ),
            "The Product insert with success",
            201
        );
    }
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $this->authorize('view', $product);
        return ApiResponse::success(new ProductResource($product));
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

        $product = $productService->update($product->id, $dto);

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
        $productService->delete($product->id);
        return response()->noContent();
    }
}
