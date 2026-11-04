<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Http\Requests\Location\Location\LocationStoreRequest;
use App\Http\Requests\Location\Location\LocationUpdateRequest;
use App\Services\LocationService\LocationService;

class LocationController extends Controller
{
    public function __construct(
        protected LocationService $locationService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return apiSuccess(
            'Todos os locais cadastrados',
            $this->locationService->all()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LocationStoreRequest $request)
    {
        return apiSuccess(
            'Local cadastrado com sucesso!',
            $this->locationService->create($request->validated()),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return apiSuccess(
            'Dados do local',
            $this->locationService->find($id)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LocationUpdateRequest $request, string $id)
    {
        return apiSuccess(
            'Dados atualizados',
            $this->locationService->update($request->validated(), $id)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
