<?php

namespace App\Http\Controllers;

use App\Http\Requests\BirthType\UpdateBirthTypeRequest;
use App\Http\Requests\BirthType\StoreBirthTypeRequest;
use App\Http\Resources\BirthTypeResource;
use App\Models\BirthType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BirthTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $birthTypes = BirthType::all()->toResourceCollection();

        return $birthTypes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBirthTypeRequest $request)
    {
        $data = $request->validated();

        $birthType = BirthType::create($data);

        return (new BirthTypeResource($birthType));
    }

    /**
     * Display the specified resource.
     */
    public function show(BirthType $birthType)
    {
        return (new BirthTypeResource($birthType));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBirthTypeRequest $request, BirthType $birthType): BirthTypeResource
    {
        $data = $request->validated();

        $birthType->update($data);

        return (new BirthTypeResource($birthType));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BirthType $birthType)
    {
        $birthType->delete();

        return response(null, 204);
    }
}
