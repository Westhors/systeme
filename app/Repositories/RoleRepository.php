<?php

namespace App\Repositories;

use App\Interfaces\RoleRepositoryInterface;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

class RoleRepository extends CrudRepository implements RoleRepositoryInterface
{
    protected Model $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }
}

