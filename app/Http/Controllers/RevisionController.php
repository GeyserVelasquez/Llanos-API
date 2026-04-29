<?php

namespace App\Http\Controllers;

use App\Http\Requests\Revision\StoreRevisionRequest;
use App\Http\Requests\Revision\UpdateRevisionRequest;
use App\Http\Resources\RevisionResource;
use App\Models\Revision;
use Illuminate\Http\Request;

class RevisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $revisions = Revision::all()->toResourceCollection();

        return $revisions;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRevisionRequest $request)
    {
        $data = $request->validated();

        $revision = Revision::create($data);

        return new RevisionResource($revision);
    }

    /**
     * Display the specified resource.
     */
    public function show(Revision $revision)
    {
        return new RevisionResource($revision);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRevisionRequest $request, Revision $revision)
    {
        $data = $request->validated();

        $revision->update($data);

        return new RevisionResource($revision);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Revision $revision)
    {
        $revision->delete();

        return response(null, 204);
    }
}
