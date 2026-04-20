<?php

namespace App\Http\Controllers;

use App\Http\Requests\Breed\UpdateBreedRequest;
use App\Http\Requests\Breed\StoreBreedRequest;
use App\Http\Resources\BreedResource;
use App\Models\Breed;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BreedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breeds = Breed::all()->toResourceCollection();

        return $breeds;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBreedRequest $request)
    {
        $data = $request->validated();

        $breed = Breed::create($data);

        return (new BreedResource($breed));
    }

    /**
     * Display the specified resource.
     */
    public function show(Breed $breed)
    {
        return (new BreedResource($breed));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBreedRequest $request, Breed $breed): BreedResource
    {
        $data = $request->validated();

        $breed->update($data);

        return (new BreedResource($breed));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Breed $breed)
    {
        $breed->delete();

        return response(null, 204);
    }
}
