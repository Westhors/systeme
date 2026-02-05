<?php

namespace App\Repositories;

use App\Interfaces\AttendanceRepositoryInterface;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;

class AttendanceRepository extends CrudRepository implements AttendanceRepositoryInterface
{
    protected Model $model;

    public function __construct(Attendance $model)
    {
        $this->model = $model;
    }
}

