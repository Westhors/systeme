<?php

namespace App\Repositories;

use App\Interfaces\EmployeeRepositoryInterface;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class EmployeeRepository extends CrudRepository implements EmployeeRepositoryInterface
{
    protected Model $model;

    public function __construct(Employee $model)
    {
        $this->model = $model;
    }
}

