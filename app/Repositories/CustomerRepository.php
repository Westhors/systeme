<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class CustomerRepository extends CrudRepository implements CustomerRepositoryInterface
{
    protected Model $model;

    public function __construct(Customer $model)
    {
        $this->model = $model;
    }
}

