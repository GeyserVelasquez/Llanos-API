<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceType\UpdateServiceTypeRequest;
use App\Http\Requests\ServiceType\StoreServiceTypeRequest;
use App\Http\Resources\ServiceTypeResource;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $serviceTypes = ServiceType::all()->toResourceCollection();

        return $serviceTypes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceTypeRequest $request)
    {
        $data = $request->validated();

        $serviceType = ServiceType::create($data);

        return (new ServiceTypeResource($serviceType));
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceType $serviceType)
    {
        return (new ServiceTypeResource($serviceType));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceTypeRequest $request, ServiceType $serviceType): ServiceTypeResource
    {
        $data = $request->validated();

        $serviceType->update($data);

        return (new ServiceTypeResource($serviceType));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceType $serviceType)
    {
        $serviceType->delete();

        return response(null, 204);
    }
}
