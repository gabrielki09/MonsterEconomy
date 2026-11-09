<?php

namespace App\Repositories\Interface;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

interface BaseInterface
{
    public function all(
        array $parameters = [],
        array $columns = ['*'],
    ): Paginator;

    public function create(array $data): Model;
    public function update(Model $model, array $data): Model;
    public function find(int $id, array $columns = ['*']): ?Model;
    public function findBy(
        array $parameters,
        array $columns = ['*'],
        array $relationships = []
    ): ?Model;

    public function existsBy(array $parameters): bool;
}
