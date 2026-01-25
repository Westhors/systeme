<?php

namespace App\Repositories;

use App\Interfaces\UnitRepositoryInterface;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Model;

class UnitRepository extends CrudRepository implements UnitRepositoryInterface
{
    protected Model $model;

    public function __construct(Unit $model)
    {
        $this->model = $model;
    }
}

