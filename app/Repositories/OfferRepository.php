<?php

namespace App\Repositories;

use App\Interfaces\OfferRepositoryInterface;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Model;

class OfferRepository extends CrudRepository implements OfferRepositoryInterface
{
    protected Model $model;

    public function __construct(Offer $model)
    {
        $this->model = $model;
    }
}

