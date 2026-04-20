<?php

namespace App\Http\Controllers;

use App\Http\Requests\MilkingType\UpdateMilkingTypeRequest;
use App\Http\Requests\MilkingType\StoreMilkingTypeRequest;
use App\Http\Resources\MilkingTypeResource;
use App\Models\MilkingType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MilkingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $milkingTypes = MilkingType::all()->toResourceCollection();

        return $milkingTypes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMilkingTypeRequest $request)
    {
        $data = $request->validated();

        $milkingType = MilkingType::create($data);

        return (new MilkingTypeResource($milkingType));
    }

    /**
     * Display the specified resource.
     */
    public function show(MilkingType $milkingType)
    {
        return (new MilkingTypeResource($milkingType));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMilkingTypeRequest $request, MilkingType $milkingType): MilkingTypeResource
    {
        $data = $request->validated();

        $milkingType->update($data);

        return (new MilkingTypeResource($milkingType));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MilkingType $milkingType)
    {
        $milkingType->delete();

        return response(null, 204);
    }
}
