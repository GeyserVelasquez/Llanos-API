<?php

namespace App\Http\Controllers;

use App\Http\Requests\GrowthType\UpdateGrowthTypeRequest;
use App\Http\Requests\GrowthType\StoreGrowthTypeRequest;
use App\Http\Resources\GrowthTypeResource;
use App\Models\GrowthType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GrowthTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $growthTypes = GrowthType::all()->toResourceCollection();

        return $growthTypes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGrowthTypeRequest $request)
    {
        $data = $request->validated();

        $growthType = GrowthType::create($data);

        return (new GrowthTypeResource($growthType));
    }

    /**
     * Display the specified resource.
     */
    public function show(GrowthType $growthType)
    {
        return (new GrowthTypeResource($growthType));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGrowthTypeRequest $request, GrowthType $growthType): GrowthTypeResource
    {
        $data = $request->validated();

        $growthType->update($data);

        return (new GrowthTypeResource($growthType));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GrowthType $growthType)
    {
        $growthType->delete();

        return response(null, 204);
    }
}
