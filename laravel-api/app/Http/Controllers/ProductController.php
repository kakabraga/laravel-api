<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;

use App\Services\ProductService;

use App\DTOs\Product\ProductDTO;

use Illuminate\Http\Request;

use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Product $product)
    {
        //
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
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
