<?php

namespace App\Services\LocationService;

use App\Repositories\Interface\LocationInterface\LocationInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LocationService
{
    public function __construct(
        protected LocationInterface $locationRepository
    ) {}

    public function all(array $columns = ['*'])
    {
        return $this->locationRepository->all($columns);
    }

    public function create(array $data)
    {
        return $this->locationRepository->create($data);
    }

    public function update(array $data, int $id): Model
    {
        $vehicle = $this->locationRepository->update($this->find($id), $data);

        return $vehicle;
    }

    public function find(int $id): ?Model
    {
        $vehicle = $this->locationRepository->find($id);

        if (!$vehicle)
        {
            throw new ModelNotFoundException('Local não localizado');
        }

        return $vehicle;
    }
}
