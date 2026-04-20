<?php

namespace App\Http\Controllers;

use App\Http\Requests\Result\UpdateResultRequest;
use App\Http\Requests\Result\StoreResultRequest;
use App\Http\Resources\ResultResource;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = Result::all()->toResourceCollection();

        return $results;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResultRequest $request)
    {
        $data = $request->validated();

        $result = Result::create($data);

        return (new ResultResource($result));
    }

    /**
     * Display the specified resource.
     */
    public function show(Result $result)
    {
        return (new ResultResource($result));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResultRequest $request, Result $result): ResultResource
    {
        $data = $request->validated();

        $result->update($data);

        return (new ResultResource($result));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Result $result)
    {
        $result->delete();

        return response(null, 204);
    }
}
