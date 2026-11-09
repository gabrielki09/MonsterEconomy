<?php

namespace App\Services\CEPService;

use Illuminate\Support\Facades\Http;
use RuntimeException;
use stdClass;

class CEPService
{
    public function __construct(
        private readonly string $apiURL
    ){}

    public function fetchAPI(string $cep): stdClass
    {
        $res = Http::withoutVerifying()
                    ->withHeaders(
                    [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json'
                    ]
                    )
                    ->timeout(30)
                    ->get($this->apiURL . "/{$cep}");

        if ($res->failed()) throw new RuntimeException('Erro ao consultar o CEP: ' . $res);

        $data = $res->json();

        $cepData = new stdClass();
        $cepData->name = $data['neighborhood'];
        $cepData->road = $data['street'];
        $cepData->address = $data['neighborhood'];
        $cepData->latitude = $data['location']['coordinates']['latitude'];
        $cepData->longitude = $data['location']['coordinates']['longitude'];

        return $cepData;
    }
}
