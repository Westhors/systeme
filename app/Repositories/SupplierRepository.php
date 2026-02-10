<?php

namespace App\Repositories;

use App\Interfaces\SupplierRepositoryInterface;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;

class SupplierRepository extends CrudRepository implements SupplierRepositoryInterface
{
    protected Model $model;

    public function __construct(Supplier $model)
    {
        $this->model = $model;
    }
}

