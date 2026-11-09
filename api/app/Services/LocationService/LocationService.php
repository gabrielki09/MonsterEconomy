<?php

namespace App\Services\LocationService;

use App\Exceptions\Location\LocationSharingNotAllowedException;
use App\Models\Location\Location;
use App\Repositories\Interface\LocationInterface\LocationInterface;
use App\Repositories\Interface\LocationInterface\LocationOperatingDayInterface;
use App\Services\CEPService\CEPService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LocationService
{
    public function __construct(
        protected LocationInterface $locationRepository,
        protected LocationOperatingDayInterface $locationOperatingDay,
        private CEPService $cepService
    ) {}

    public function all(
        array $parameters
    ): Paginator {
        Log::info($parameters);
        return $this->locationRepository->all(
            parameters: $parameters
        );
    }

    public function findBy(
        array $parameters = [],
        array $columns = ['*'],
        array $relationships = []
    ): ?Location {
        return $this->locationRepository->findBy(
            parameters: $parameters,
            columns: $columns,
            relationships: $relationships
        );
    }

    private function validateSharing(array $parameters): void
    {
        $blockedLocationExists = $this->locationRepository->existsBy([
            ...$parameters,
            'shares_more_than_one_location' => false,
        ]);

        if ($blockedLocationExists) {
            throw new LocationSharingNotAllowedException(
                'Já existe esse endereço cadastrado e ele não permite compartilhamento.'
            );
        }
    }

    public function create(array $data)
    {
        $consultByCEP = filter_var(
            $data['consult_by_cep'] ?? false,
            FILTER_VALIDATE_BOOLEAN
        );

        if ($consultByCEP)
        {
            $this->validateSharing([
                'cep' => $data['cep']
            ]);

            $dataConsultByCEP = $this->cepService->fetchAPI(
                $data['cep']
            );

            $data['name'] = $dataConsultByCEP->name;
            $data['road'] = $dataConsultByCEP->road;
            $data['address'] = $dataConsultByCEP->address;
            $data['latitude'] = $dataConsultByCEP->latitude;
            $data['longitude'] = $dataConsultByCEP->longitude;
        } else {
            $this->validateSharing([
                'road' => $data['road'],
                'address' => $data['address'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ]);
        }

        return DB::transaction(function() use ($data) {
            $location = $this->locationRepository->create($data);

            $this->locationOperatingDay->create([
                'location_id' => $location->id,
                'opening_day' => $data['opening_day'],
                'opens_at' => $data['opens_at'],
                'closes_at' => $data['closes_at'],
            ]);

            return $location->with('locationWithLocationOperatingDay')->get();
        });
    }

    public function update(array $data, int $id): Location
    {
        $location = $this->locationRepository->update($this->find($id), $data);

        return $location;
    }

    public function find(int $id, array $columns = ['*'],): ?Location
    {
        $location = $this->locationRepository->find(
            id: $id,
            columns: $columns
        );

        if ($location === null) throw (new ModelNotFoundException())->setModel(Location::class, [$id]);

        return $location;
    }
}
