<?php

namespace App\Repositories;

use App\Interfaces\TaxRepositoryInterface;
use App\Models\Tax;
use Illuminate\Database\Eloquent\Model;

class TaxRepository extends CrudRepository implements TaxRepositoryInterface
{
    protected Model $model;

    public function __construct(Tax $model)
    {
        $this->model = $model;
    }
}

