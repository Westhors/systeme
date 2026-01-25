<?php

namespace App\Repositories;

use App\Interfaces\WarehouseRepositoryInterface;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Model;

class WarehouseRepository extends CrudRepository implements WarehouseRepositoryInterface
{
    protected Model $model;

    public function __construct(Warehouse $model)
    {
        $this->model = $model;
    }
}
