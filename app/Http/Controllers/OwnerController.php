<?php

namespace App\Http\Controllers;

use App\Http\Requests\Owner\UpdateOwnerRequest;
use App\Http\Requests\Owner\StoreOwnerRequest;
use App\Http\Resources\OwnerResource;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $owners = Owner::all()->toResourceCollection();

        return $owners;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOwnerRequest $request)
    {
        $data = $request->validated();

        $owner = Owner::create($data);

        return (new OwnerResource($owner));
    }

    /**
     * Display the specified resource.
     */
    public function show(Owner $owner)
    {
        return (new OwnerResource($owner));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOwnerRequest $request, Owner $owner): OwnerResource
    {
        $data = $request->validated();

        $owner->update($data);

        return (new OwnerResource($owner));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Owner $owner)
    {
        $owner->delete();

        return response(null, 204);
    }
}
