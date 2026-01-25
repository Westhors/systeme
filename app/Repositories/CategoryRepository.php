<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends CrudRepository implements CategoryRepositoryInterface
{
    protected Model $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }
}

