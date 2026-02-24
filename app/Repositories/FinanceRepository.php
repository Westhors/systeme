<?php

namespace App\Repositories;

use App\Interfaces\FinanceRepositoryInterface;
use App\Models\Finance;
use Illuminate\Database\Eloquent\Model;

class FinanceRepository extends CrudRepository implements FinanceRepositoryInterface
{
    protected Model $model;

    public function __construct(Finance $model)
    {
        $this->model = $model;
    }
}


