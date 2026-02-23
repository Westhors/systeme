<?php

namespace App\Repositories;

use App\Interfaces\RevenueRepositoryInterface;
use App\Models\Revenue;
use Illuminate\Database\Eloquent\Model;

class RevenueRepository extends CrudRepository implements RevenueRepositoryInterface
{
    protected Model $model;

    public function __construct(Revenue $model)
    {
        $this->model = $model;
    }
}

