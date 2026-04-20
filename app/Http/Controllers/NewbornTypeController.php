<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewbornType\UpdateNewbornTypeRequest;
use App\Http\Requests\NewbornType\StoreNewbornTypeRequest;
use App\Http\Resources\NewbornTypeResource;
use App\Models\NewbornType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NewbornTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $newbornTypes = NewbornType::all()->toResourceCollection();

        return $newbornTypes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewbornTypeRequest $request)
    {
        $data = $request->validated();

        $newbornType = NewbornType::create($data);

        return (new NewbornTypeResource($newbornType));
    }

    /**
     * Display the specified resource.
     */
    public function show(NewbornType $newbornType)
    {
        return (new NewbornTypeResource($newbornType));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewbornTypeRequest $request, NewbornType $newbornType): NewbornTypeResource
    {
        $data = $request->validated();

        $newbornType->update($data);

        return (new NewbornTypeResource($newbornType));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewbornType $newbornType)
    {
        $newbornType->delete();

        return response(null, 204);
    }
}
