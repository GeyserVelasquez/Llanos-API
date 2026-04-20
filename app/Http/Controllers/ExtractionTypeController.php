<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExtractionType\UpdateExtractionTypeRequest;
use App\Http\Requests\ExtractionType\StoreExtractionTypeRequest;
use App\Http\Resources\ExtractionTypeResource;
use App\Models\ExtractionType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExtractionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $extractionTypes = ExtractionType::all()->toResourceCollection();

        return $extractionTypes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExtractionTypeRequest $request)
    {
        $data = $request->validated();

        $extractionType = ExtractionType::create($data);

        return (new ExtractionTypeResource($extractionType));
    }

    /**
     * Display the specified resource.
     */
    public function show(ExtractionType $extractionType)
    {
        return (new ExtractionTypeResource($extractionType));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExtractionTypeRequest $request, ExtractionType $extractionType): ExtractionTypeResource
    {
        $data = $request->validated();

        $extractionType->update($data);

        return (new ExtractionTypeResource($extractionType));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExtractionType $extractionType)
    {
        $extractionType->delete();

        return response(null, 204);
    }
}
