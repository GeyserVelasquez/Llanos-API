<?php

namespace App\Http\Controllers;

use App\Http\Requests\Supply\StoreSupplyRequest;
use App\Http\Requests\Supply\UpdateSupplyRequest;
use App\Http\Resources\SupplyResource;
use App\Models\Supply;
use Illuminate\Http\Request;

class SupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supplies = Supply::all()->toResourceCollection();

        return $supplies;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplyRequest $request)
    {
        $data = $request->validated();

        $supply = Supply::create($data);

        return new SupplyResource($supply);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supply $supply)
    {
        return new SupplyResource($supply);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplyRequest $request, Supply $supply)
    {
        $data = $request->validated();

        $supply->update($data);

        return new SupplyResource($supply);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supply $supply)
    {
        $supply->delete();

        return response(null, 204);
    }
}
