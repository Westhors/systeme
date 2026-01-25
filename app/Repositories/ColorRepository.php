<?php

namespace App\Repositories;

use App\Interfaces\ColorRepositoryInterface;
use App\Models\Color;
use Illuminate\Database\Eloquent\Model;

class ColorRepository extends CrudRepository implements ColorRepositoryInterface
{
    protected Model $model;

    public function __construct(Color $model)
    {
        $this->model = $model;
    }
}

