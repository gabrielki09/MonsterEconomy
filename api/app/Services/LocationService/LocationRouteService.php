<?php

namespace App\Services\LocationService;

use App\Repositories\Interface\LocationInterface\LocationRouteInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LocationRouteService
{
    public function __construct(
        protected LocationRouteInterface $locationRouteRepository
    ) {}

    public function all(array $columns = ['*'])
    {
        return $this->locationRouteRepository->all($columns);
    }

    public function create(array $data)
    {
        return $this->locationRouteRepository->create($data);
    }

    public function update(array $data, int $id): Model
    {
        $vehicle = $this->locationRouteRepository->update($this->find($id), $data);

        return $vehicle;
    }

    public function find(int $id): ?Model
    {
        $vehicle = $this->locationRouteRepository->find($id);

        if (!$vehicle)
        {
            throw new ModelNotFoundException('Rota do local não localizado');
        }

        return $vehicle;
    }
}
