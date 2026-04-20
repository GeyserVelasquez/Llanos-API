<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductMovementType\UpdateProductMovementTypeRequest;
use App\Http\Requests\ProductMovementType\StoreProductMovementTypeRequest;
use App\Http\Resources\ProductMovementTypeResource;
use App\Models\ProductMovementType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductMovementTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productMovementTypes = ProductMovementType::all()->toResourceCollection();

        return $productMovementTypes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductMovementTypeRequest $request)
    {
        $data = $request->validated();

        $productMovementType = ProductMovementType::create($data);

        return (new ProductMovementTypeResource($productMovementType));
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductMovementType $productMovementType)
    {
        return (new ProductMovementTypeResource($productMovementType));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductMovementTypeRequest $request, ProductMovementType $productMovementType): ProductMovementTypeResource
    {
        $data = $request->validated();

        $productMovementType->update($data);

        return (new ProductMovementTypeResource($productMovementType));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductMovementType $productMovementType)
    {
        $productMovementType->delete();

        return response(null, 204);
    }
}
