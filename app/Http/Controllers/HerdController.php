<?php

namespace App\Http\Controllers;

use App\Http\Requests\Herd\UpdateHerdRequest;
use App\Http\Requests\Herd\StoreHerdRequest;
use App\Http\Resources\HerdResource;
use App\Models\Herd;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HerdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $herds = Herd::all()->toResourceCollection();

        return $herds;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHerdRequest $request)
    {
        $data = $request->validated();

        $herd = Herd::create($data);

        return (new HerdResource($herd));
    }

    /**
     * Display the specified resource.
     */
    public function show(Herd $herd)
    {
        return (new HerdResource($herd));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHerdRequest $request, Herd $herd): HerdResource
    {
        $data = $request->validated();

        $herd->update($data);

        return (new HerdResource($herd));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Herd $herd)
    {
        $herd->delete();

        return response(null, 204);
    }
}
