<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vehicle\VehicleStoreRequest;
use App\Http\Requests\Vehicle\VehicleUpdateRequest;
use App\Services\VehicleService\VehicleService;

class VehicleController extends Controller
{
    public function __construct(
        protected VehicleService $vehicleService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return apiSuccess(
            'Todos os veículos cadastrados',
            $this->vehicleService->all()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VehicleStoreRequest $request)
    {
        return apiSuccess(
            'Veículo cadastrado com sucesso!',
            $this->vehicleService->create($request->validated()),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return apiSuccess(
            'Dados do veículo',
            $this->vehicleService->find($id)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VehicleUpdateRequest $request, int $id)
    {
        return apiSuccess(
            'Dados atualizados',
            $this->vehicleService->update($request->validated(), $id)
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
