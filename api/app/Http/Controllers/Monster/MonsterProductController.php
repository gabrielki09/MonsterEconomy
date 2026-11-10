<?php

namespace App\Http\Controllers\Monster;

use App\Http\Controllers\Controller;
use App\Http\Requests\Monster\MonsterProductStoreRequest;
use App\Services\MonsterService\MonsterProductService;
use Illuminate\Http\Request;

class MonsterProductController extends Controller
{
    public function __construct(
        protected MonsterProductService $monsterProductService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MonsterProductStoreRequest $request)
    {
        return apiSuccess(
            'Monster cadastrado com sucesso!',
            [
                'monster_product' => $this->monsterProductService->create($request->validated())
            ],
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MonsterProductStoreRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
