<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Http\Requests\Location\LocationRoute\LocationRouteStoreRequest;
use App\Http\Requests\Location\LocationRoute\LocationRouteUpdateRequest;
use App\Services\LocationService\LocationRouteService;

class LocationRouteController extends Controller
{
    public function __construct(
        protected LocationRouteService $locationRouteService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return apiSuccess(
            'Todos as rotas dos locais cadastradas',
            $this->locationRouteService->all()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LocationRouteStoreRequest $request)
    {
        return apiSuccess(
            'Rota do local cadastrada com sucesso!',
            $this->locationRouteService->create($request->validated()),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return apiSuccess(
            'Dados da rota do local',
            $this->locationRouteService->find($id)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LocationRouteUpdateRequest $request, string $id)
    {
        return apiSuccess(
            'Dados atualizados',
            $this->locationRouteService->update($request->validated(), $id)
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
