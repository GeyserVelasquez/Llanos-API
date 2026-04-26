<?php

namespace App\Http\Controllers;

use App\Http\Requests\BatchMovement\StoreBatchMovementRequest;
use App\Http\Requests\BatchMovement\UpdateBatchMovementRequest;
use App\Http\Resources\BatchMovementResource;
use App\Models\BatchMovement;
use Illuminate\Http\Request;

class BatchMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batchMovements = BatchMovement::all()->toResourceCollection();

        return $batchMovements;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBatchMovementRequest $request)
    {
        $data = $request->validated();

        $batchMovement = BatchMovement::create($data);

        return new BatchMovementResource($batchMovement);
    }

    /**
     * Display the specified resource.
     */
    public function show(BatchMovement $batchMovement)
    {
        return new BatchMovementResource($batchMovement);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBatchMovementRequest $request, BatchMovement $batchMovement)
    {
        $data = $request->validated();

        $batchMovement->update($data);

        return new BatchMovementResource($batchMovement);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BatchMovement $batchMovement)
    {
        $batchMovement->delete();

        return response(null, 204);
    }
}
