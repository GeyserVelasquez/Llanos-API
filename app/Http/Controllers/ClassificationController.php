<?php

namespace App\Http\Controllers;

use App\Http\Requests\Classification\UpdateClassificationRequest;
use App\Http\Requests\Classification\StoreClassificationRequest;
use App\Http\Resources\ClassificationResource;
use App\Models\Classification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classifications = Classification::all()->toResourceCollection();

        return $classifications;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClassificationRequest $request)
    {
        $data = $request->validated();

        $classification = Classification::create($data);

        return (new ClassificationResource($classification));
    }

    /**
     * Display the specified resource.
     */
    public function show(Classification $classification)
    {
        return (new ClassificationResource($classification));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClassificationRequest $request, Classification $classification): ClassificationResource
    {
        $data = $request->validated();

        $classification->update($data);

        return (new ClassificationResource($classification));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classification $classification)
    {
        $classification->delete();

        return response(null, 204);
    }
}
