<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbortType\UpdateAbortTypeRequest;
use App\Http\Requests\AbortType\StoreAbortTypeRequest;
use App\Http\Resources\AbortTypeResource;
use App\Models\AbortType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AbortTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abortTypes = AbortType::all()->toResourceCollection();

        return $abortTypes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAbortTypeRequest $request)
    {
        $data = $request->validated();

        $abortType = AbortType::create($data);

        return (new AbortTypeResource($abortType));
    }

    /**
     * Display the specified resource.
     */
    public function show(AbortType $abortType)
    {
        return (new AbortTypeResource($abortType));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAbortTypeRequest $request, AbortType $abortType): AbortTypeResource
    {
        $data = $request->validated();

        $abortType->update($data);

        return (new AbortTypeResource($abortType));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AbortType $abortType)
    {
        $abortType->delete();

        return response(null, 204);
    }
}
