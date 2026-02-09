<?php

namespace App\Repositories;

use App\Interfaces\LoyaltySettingRepositoryInterface;
use App\Models\LoyaltySetting;
use Illuminate\Database\Eloquent\Model;

class LoyaltySettingRepository extends CrudRepository implements LoyaltySettingRepositoryInterface
{
    protected Model $model;

    public function __construct(LoyaltySetting $model)
    {
        $this->model = $model;
    }
}
