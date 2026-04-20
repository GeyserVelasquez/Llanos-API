<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplyType\UpdateSupplyTypeRequest;
use App\Http\Requests\SupplyType\StoreSupplyTypeRequest;
use App\Http\Resources\SupplyTypeResource;
use App\Models\SupplyType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supplyTypes = SupplyType::all()->toResourceCollection();

        return $supplyTypes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplyTypeRequest $request)
    {
        $data = $request->validated();

        $supplyType = SupplyType::create($data);

        return (new SupplyTypeResource($supplyType));
    }

    /**
     * Display the specified resource.
     */
    public function show(SupplyType $supplyType)
    {
        return (new SupplyTypeResource($supplyType));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplyTypeRequest $request, SupplyType $supplyType): SupplyTypeResource
    {
        $data = $request->validated();

        $supplyType->update($data);

        return (new SupplyTypeResource($supplyType));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupplyType $supplyType)
    {
        $supplyType->delete();

        return response(null, 204);
    }
}
