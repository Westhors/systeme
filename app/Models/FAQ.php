<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

/**
 *
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $des
 * @property int|null $position
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @method static Builder|FAQ filter($filters = null, $filterOperator = '=')
 * @method static Builder|FAQ newModelQuery()
 * @method static Builder|FAQ newQuery()
 * @method static Builder|FAQ onlyTrashed()
 * @method static Builder|FAQ query()
 * @method static Builder|FAQ whereCreatedAt($value)
 * @method static Builder|FAQ whereDeletedAt($value)
 * @method static Builder|FAQ whereDes($value)
 * @method static Builder|FAQ whereId($value)
 * @method static Builder|FAQ whereName($value)
 * @method static Builder|FAQ whereOrderId($value)
 * @method static Builder|FAQ whereUpdatedAt($value)
 * @method static Builder|FAQ withTrashed()
 * @method static Builder|FAQ withoutTrashed()
 * @mixin Eloquent
 */
class FAQ extends BaseModel
{
    protected $guarded = ['id'];


    protected $casts = [
        'active' => 'boolean'
    ];

}
