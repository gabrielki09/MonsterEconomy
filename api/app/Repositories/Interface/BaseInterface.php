<?php

namespace App\Repositories\Interface;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseInterface
{
    public function all(array $columns = ['*']): Collection;
    public function create(array $data): Model;
    public function update(Model $model, array $data): Model;
    public function find(int $id): ?Model;
}
