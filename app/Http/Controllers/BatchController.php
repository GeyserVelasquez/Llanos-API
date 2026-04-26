<?php

namespace App\Http\Controllers;

use App\Http\Requests\Batch\UpdateBatchRequest;
use App\Http\Requests\Batch\StoreBatchRequest;
use App\Http\Resources\BatchResource;
use App\Models\batch;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batches = Batch::all()->toResourceCollection();

        return $batches;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBatchRequest $request)
    {
        $data = $request->validated();

        $batch = Batch::create($data);

        return (new BatchResource($batch));
    }

    /**
     * Display the specified resource.
     */
    public function show(batch $batch)
    {
        return (new BatchResource($batch));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBatchRequest $request, Batch $batch): BatchResource
    {
        $data = $request->validated();

        $batch->update($data);

        return (new BatchResource($batch));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(batch $batch)
    {
        $batch->delete();

        return response(null, 204);
    }
}
