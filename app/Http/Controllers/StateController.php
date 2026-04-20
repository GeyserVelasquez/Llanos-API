<?php

namespace App\Http\Controllers;

use App\Http\Requests\State\UpdateStateRequest;
use App\Http\Requests\State\StoreStateRequest;
use App\Http\Resources\StateResource;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $states = State::all()->toResourceCollection();

        return $states;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStateRequest $request)
    {
        $data = $request->validated();

        $state = State::create($data);

        return (new StateResource($state));
    }

    /**
     * Display the specified resource.
     */
    public function show(State $state)
    {
        return (new StateResource($state));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStateRequest $request, State $state): StateResource
    {
        $data = $request->validated();

        $state->update($data);

        return (new StateResource($state));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(State $state)
    {
        $state->delete();

        return response(null, 204);
    }
}
