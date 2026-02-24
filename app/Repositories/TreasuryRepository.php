<?php

namespace App\Repositories;

use App\Interfaces\TreasuryRepositoryInterface;
use App\Models\Treasury;
use Illuminate\Database\Eloquent\Model;

class TreasuryRepository extends CrudRepository implements TreasuryRepositoryInterface
{
    protected Model $model;

    public function __construct(Treasury $model)
    {
        $this->model = $model;
    }
}

