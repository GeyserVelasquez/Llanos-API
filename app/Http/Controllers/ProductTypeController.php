<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductType\UpdateProductTypeRequest;
use App\Http\Requests\ProductType\StoreProductTypeRequest;
use App\Http\Resources\ProductTypeResource;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productTypes = ProductType::all()->toResourceCollection();

        return $productTypes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductTypeRequest $request)
    {
        $data = $request->validated();

        $productType = ProductType::create($data);

        return (new ProductTypeResource($productType));
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductType $productType)
    {
        return (new ProductTypeResource($productType));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductTypeRequest $request, ProductType $productType): ProductTypeResource
    {
        $data = $request->validated();

        $productType->update($data);

        return (new ProductTypeResource($productType));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductType $productType)
    {
        $productType->delete();

        return response(null, 204);
    }
}
