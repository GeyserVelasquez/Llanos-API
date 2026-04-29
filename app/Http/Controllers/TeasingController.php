<?php

namespace App\Http\Controllers;

use App\Http\Requests\Teasing\StoreTeasingRequest;
use App\Http\Requests\Teasing\UpdateTeasingRequest;
use App\Http\Resources\TeasingResource;
use App\Models\Teasing;
use Illuminate\Http\Request;

class TeasingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teasings = Teasing::all()->toResourceCollection();

        return $teasings;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeasingRequest $request)
    {
        $data = $request->validated();

        $teasing = Teasing::create($data);

        return new TeasingResource($teasing);
    }

    /**
     * Display the specified resource.
     */
    public function show(Teasing $teasing)
    {
        return new TeasingResource($teasing);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeasingRequest $request, Teasing $teasing)
    {
        $data = $request->validated();

        $teasing->update($data);

        return new TeasingResource($teasing);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teasing $teasing)
    {
        $teasing->delete();

        return response(null, 204);
    }
}
