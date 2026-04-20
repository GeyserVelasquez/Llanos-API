<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnimalCategory\UpdateAnimalCategoryRequest;
use App\Http\Requests\AnimalCategory\StoreAnimalCategoryRequest;
use App\Http\Resources\AnimalCategoryResource;
use App\Models\AnimalCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AnimalCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $animalCategories = AnimalCategory::all()->toResourceCollection();

        return $animalCategories;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnimalCategoryRequest $request)
    {
        $data = $request->validated();

        $animalCategory = AnimalCategory::create($data);

        return (new AnimalCategoryResource($animalCategory));
    }

    /**
     * Display the specified resource.
     */
    public function show(AnimalCategory $animalCategory)
    {
        return (new AnimalCategoryResource($animalCategory));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnimalCategoryRequest $request, AnimalCategory $animalCategory): AnimalCategoryResource
    {
        $data = $request->validated();

        $animalCategory->update($data);

        return (new AnimalCategoryResource($animalCategory));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnimalCategory $animalCategory)
    {
        $animalCategory->delete();

        return response(null, 204);
    }
}
