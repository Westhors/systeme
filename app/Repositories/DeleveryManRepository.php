<?php

namespace App\Repositories;

use App\Interfaces\DeleveryManRepositoryInterface;
use App\Models\DeleveryMan;
use Illuminate\Database\Eloquent\Model;

class DeleveryManRepository extends CrudRepository implements DeleveryManRepositoryInterface
{
    protected Model $model;

    public function __construct(DeleveryMan $model)
    {
        $this->model = $model;
    }
}

