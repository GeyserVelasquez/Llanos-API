<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutcomeType\UpdateOutcomeTypeRequest;
use App\Http\Requests\OutcomeType\StoreOutcomeTypeRequest;
use App\Http\Resources\OutcomeTypeResource;
use App\Models\OutcomeType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OutcomeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outcomeTypes = OutcomeType::all()->toResourceCollection();

        return $outcomeTypes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOutcomeTypeRequest $request)
    {
        $data = $request->validated();

        $outcomeType = OutcomeType::create($data);

        return (new OutcomeTypeResource($outcomeType));
    }

    /**
     * Display the specified resource.
     */
    public function show(OutcomeType $outcomeType)
    {
        return (new OutcomeTypeResource($outcomeType));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOutcomeTypeRequest $request, OutcomeType $outcomeType): OutcomeTypeResource
    {
        $data = $request->validated();

        $outcomeType->update($data);

        return (new OutcomeTypeResource($outcomeType));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutcomeType $outcomeType)
    {
        $outcomeType->delete();

        return response(null, 204);
    }
}
