<?php

namespace App\Http\Controllers;

use App\Http\Requests\Color\UpdateColorRequest;
use App\Http\Requests\Color\StoreColorRequest;
use App\Http\Resources\ColorResource;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = Color::all()->toResourceCollection();

        return $colors;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreColorRequest $request)
    {
        $data = $request->validated();

        $color = Color::create($data);

        return (new ColorResource($color));
    }

    /**
     * Display the specified resource.
     */
    public function show(Color $color)
    {
        return (new ColorResource($color));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateColorRequest $request, Color $color): ColorResource
    {
        $data = $request->validated();

        $color->update($data);

        return (new ColorResource($color));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Color $color)
    {
        $color->delete();

        return response(null, 204);
    }
}
