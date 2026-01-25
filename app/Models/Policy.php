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
 * @property string $title
 * @property string $slug
 * @property int $active
 * @property string|null $description
 * @property int $position
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @method static Builder|Policy filter($filters = null, $filterOperator = '=')
 * @method static Builder|Policy newModelQuery()
 * @method static Builder|Policy newQuery()
 * @method static Builder|Policy onlyTrashed()
 * @method static Builder|Policy query()
 * @method static Builder|Policy whereActive($value)
 * @method static Builder|Policy whereCreatedAt($value)
 * @method static Builder|Policy whereDeletedAt($value)
 * @method static Builder|Policy whereDescription($value)
 * @method static Builder|Policy whereId($value)
 * @method static Builder|Policy wherePosition($value)
 * @method static Builder|Policy whereSlug($value)
 * @method static Builder|Policy whereTitle($value)
 * @method static Builder|Policy whereUpdatedAt($value)
 * @method static Builder|Policy withTrashed()
 * @method static Builder|Policy withoutTrashed()
 * @mixin Eloquent
 */
class Policy extends BaseModel
{
    protected $guarded = ['id'];
    protected $casts = [
        'active' => 'boolean',
    ];
}
