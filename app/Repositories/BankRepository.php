<?php

namespace App\Repositories;

use App\Interfaces\BankRepositoryInterface;
use App\Models\Bank;
use Illuminate\Database\Eloquent\Model;

class BankRepository extends CrudRepository implements BankRepositoryInterface
{
    protected Model $model;

    public function __construct(Bank $model)
    {
        $this->model = $model;
    }
}

