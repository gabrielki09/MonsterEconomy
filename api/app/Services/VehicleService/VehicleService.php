<?php

namespace App\Services\VehicleService;

use App\Repositories\Interface\VehicleInterface\VehicleInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VehicleService
{
    public function __construct(
        protected VehicleInterface $vehicleRepository
    ) {}

    public function all(array $columns = ['*'])
    {
        return $this->vehicleRepository->all($columns);
    }

    public function create(array $data)
    {
        return $this->vehicleRepository->create($data);
    }

    public function update(array $data, int $id): Model
    {
        $vehicle = $this->vehicleRepository->update($this->find($id), $data);

        return $vehicle;
    }

    public function find(int $id): ?Model
    {
        $vehicle = $this->vehicleRepository->find($id);

        if (!$vehicle)
        {
            throw new ModelNotFoundException('Veículo não localizado');
        }

        return $vehicle;
    }
}
