<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmbrionExtractionType\UpdateEmbrionExtractionTypeRequest;
use App\Http\Requests\EmbrionExtractionType\StoreEmbrionExtractionTypeRequest;
use App\Http\Resources\EmbrionExtractionTypeResource;
use App\Models\EmbrionExtractionType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmbrionExtractionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $embrionExtractionTypes = EmbrionExtractionType::all()->toResourceCollection();

        return $embrionExtractionTypes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmbrionExtractionTypeRequest $request)
    {
        $data = $request->validated();

        $embrionExtractionType = EmbrionExtractionType::create($data);

        return (new EmbrionExtractionTypeResource($embrionExtractionType));
    }

    /**
     * Display the specified resource.
     */
    public function show(EmbrionExtractionType $embrionExtractionType)
    {
        return (new EmbrionExtractionTypeResource($embrionExtractionType));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmbrionExtractionTypeRequest $request, EmbrionExtractionType $embrionExtractionType): EmbrionExtractionTypeResource
    {
        $data = $request->validated();

        $embrionExtractionType->update($data);

        return (new EmbrionExtractionTypeResource($embrionExtractionType));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmbrionExtractionType $embrionExtractionType)
    {
        $embrionExtractionType->delete();

        return response(null, 204);
    }
}
