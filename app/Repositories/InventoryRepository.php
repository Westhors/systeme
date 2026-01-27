<?php

namespace App\Repositories;

use App\Interfaces\InventoryRepositoryInterface;
use App\Models\InventoryLog;
use Illuminate\Database\Eloquent\Model;

class InventoryRepository extends CrudRepository implements InventoryRepositoryInterface
{
    protected Model $model;

    public function __construct(InventoryLog $model)
    {
        $this->model = $model;
    }
}

