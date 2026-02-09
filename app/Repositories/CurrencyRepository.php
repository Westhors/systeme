<?php

namespace App\Repositories;

use App\Interfaces\CurrencyRepositoryInterface;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;

class CurrencyRepository extends CrudRepository implements CurrencyRepositoryInterface
{
    protected Model $model;

    public function __construct(Currency $model)
    {
        $this->model = $model;
    }
}

