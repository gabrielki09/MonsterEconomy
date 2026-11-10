<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use App\Http\Requests\Filters\FilterV1Request;
use App\Http\Requests\Location\Location\LocationStoreRequest;
use App\Http\Requests\Location\Location\LocationUpdateRequest;
use App\Http\Requests\Location\LocationOperatingDay\LocationOperatingDayUpdateRequest;
use App\Services\LocationService\LocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    public function __construct(
        protected LocationService $locationService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(FilterV1Request $req)
    {
        return apiSuccess(
            'Todos os locais cadastrados',
            $this->locationService->all(
                $req->validated()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LocationStoreRequest $request)
    {
        return apiSuccess(
            'Local cadastrado com sucesso!',
            [
                'location' => $this->locationService->create($request->validated()),
            ],
            status: 201
        );
    }

    public function getOpeningHours(Request $req, string $location)
    {
        Log::info($req->all());

        return apiSuccess(
            'Dados do local',
            $this->locationService->findBy(
                parameters: [
                    'location' => $location,
                    'day' => $req->input('day')
                ]
            )
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return apiSuccess(
            'Dados do local',
            $this->locationService->find($id)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LocationUpdateRequest $request, int $id)
    {
        return apiSuccess(
            'Dados atualizados',
            [
                'location' => $this->locationService->update($request->validated(), $id)
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //
    }

    public function restore(int $id)
    {
        //
    }
}
