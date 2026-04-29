<?php

namespace App\Http\Controllers;

use App\Http\Requests\Milking\StoreMilkingRequest;
use App\Http\Requests\Milking\UpdateMilkingRequest;
use App\Http\Resources\MilkingResource;
use App\Models\Milking;
use Illuminate\Http\Request;

class MilkingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $milkings = Milking::all()->toResourceCollection();

        return $milkings;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMilkingRequest $request)
    {
        $data = $request->validated();

        $milking = Milking::create($data);

        return new MilkingResource($milking);
    }

    /**
     * Display the specified resource.
     */
    public function show(Milking $milking)
    {
        return new MilkingResource($milking);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMilkingRequest $request, Milking $milking)
    {
        $data = $request->validated();

        $milking->update($data);

        return new MilkingResource($milking);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Milking $milking)
    {
        $milking->delete();

        return response(null, 204);
    }
}
