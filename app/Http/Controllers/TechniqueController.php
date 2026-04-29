<?php

namespace App\Http\Controllers;

use App\Http\Requests\Technique\UpdateTechniqueRequest;
use App\Http\Requests\Technique\StoreTechniqueRequest;
use App\Http\Resources\TechniqueResource;
use App\Models\Technique;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TechniqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $techniques = Technique::all()->toResourceCollection();

        return $techniques;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTechniqueRequest $request)
    {
        $data = $request->validated();

        $technique = Technique::create($data);

        return (new TechniqueResource($technique));
    }

    /**
     * Display the specified resource.
     */
    public function show(Technique $technique)
    {
        return (new TechniqueResource($technique));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTechniqueRequest $request, Technique $technique): TechniqueResource
    {
        $data = $request->validated();

        $technique->update($data);

        return (new TechniqueResource($technique));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technique $technique)
    {
        $technique->delete();

        return response(null, 204);
    }
}
