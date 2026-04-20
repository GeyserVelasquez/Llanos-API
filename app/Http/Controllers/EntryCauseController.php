<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntryCause\UpdateEntryCauseRequest;
use App\Http\Requests\EntryCause\StoreEntryCauseRequest;
use App\Http\Resources\EntryCauseResource;
use App\Models\EntryCause;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EntryCauseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entryCauses = EntryCause::all()->toResourceCollection();

        return $entryCauses;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEntryCauseRequest $request)
    {
        $data = $request->validated();

        $entryCause = EntryCause::create($data);

        return (new EntryCauseResource($entryCause));
    }

    /**
     * Display the specified resource.
     */
    public function show(EntryCause $entryCause)
    {
        return (new EntryCauseResource($entryCause));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEntryCauseRequest $request, EntryCause $entryCause): EntryCauseResource
    {
        $data = $request->validated();

        $entryCause->update($data);

        return (new EntryCauseResource($entryCause));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EntryCause $entryCause)
    {
        $entryCause->delete();

        return response(null, 204);
    }
}
