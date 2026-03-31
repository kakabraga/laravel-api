<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

use App\Services\ProductService;

use App\DTOs\Product\ProductDTO;
use App\DTOs\Product\UpdateProductDTO;

use Illuminate\Http\Request;

use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductService $productService, Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $perPage = max(1, min($perPage, 50));
        return ProductResource::collection(
            $productService->paginate($perPage)
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreProductRequest $request)
    {

    }

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

        return new ProductResource(
            $productService->create($ProdutoDTO)
        );
    }
    /**
     * Display the specified resource.
     */
    public function show(int $id, ProductService $productService)
    {
        return new ProductResource(
            $productService->findById($id)
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        int $id,
        UpdateProductRequest $request,
        ProductService $productService
    ) {

        $dto = new UpdateProductDTO(
            name: $request->name,
            quantity: $request->quantity,
            weight: $request->weight,
            price: $request->price,
        );

        $product = $productService->update($id, $dto);

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id, ProductService $productService)
    {
        $productService->delete($id);
        return response()->json([
            'message' => 'Produto deletado com sucesso'
        ]);
    }
}
