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

use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;
    public function index(ProductService $productService, Request $request)
    {
        // $perPage = $request->input('per_page', 10);
        // $perPage = max(1, min($perPage, 50));
        $userId = $request->user()->id;
        return ProductResource::collection(
            $productService->list($request->all(), $userId)
        );
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */


    public function store(StoreProductRequest $request, ProductService $productService)
    {
        $ProdutoDTO = new ProductDTO(
            name: $request->name,
            quantity: $request->quantity,
            weight: $request->weight,
            price: $request->price
        );
        $userId = $request->user()->id;
        return new ProductResource(
            $productService->create($ProdutoDTO, $userId)
        );
    }
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $this->authorize('view', $product);

        return new ProductResource($product);
    }


    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
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

        return new ProductResource($product);
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
