<?php

namespace App\Http\Controllers;

use App\Http\Requests\Breed\UpdateBreedRequest;
use App\Http\Requests\Livestock\StoreLivestockRequest;
use App\Http\Requests\Livestock\UpdateLivestockRequest;
use App\Http\Resources\LivestockResource;
use App\Models\Livestock;
use Illuminate\Http\Request;

class LivestockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $livestock = Livestock::all()->toResourceCollection();

        return $livestock;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLivestockRequest $request): LivestockResource
    {
        $data = $request->validated();

        $livestock = Livestock::create($data);

        return (new LivestockResource($livestock));
    }

    /**
     * Display the specified resource.
     */
    public function show(Livestock $livestock): LivestockResource
    {
        return (new LivestockResource($livestock));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLivestockRequest $request, Livestock $livestock): LivestockResource
    {
        $data = $request->validated();

        $livestock->update($data);

        return (new LivestockResource($livestock));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Livestock $livestock)
    {
        $livestock->delete();

        return response(null, 204);
    }
}
