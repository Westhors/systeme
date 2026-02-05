<?php

namespace App\Repositories;

use App\Interfaces\SalesRepresentativeRepositoryInterface;
use App\Models\SalesRepresentative;
use Illuminate\Database\Eloquent\Model;

class SalesRepresentativeRepository extends CrudRepository implements SalesRepresentativeRepositoryInterface
{
    protected Model $model;

    public function __construct(SalesRepresentative $model)
    {
        $this->model = $model;
    }
}

