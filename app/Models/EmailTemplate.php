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
 * @property string|null $subject
 * @property string|null $body
 * @property string|null $bcc
 * @property string|null $slug
 * @property string|null $source
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @method static Builder|EmailTemplate filter($filters = null, $filterOperator = '=')
 * @method static Builder|EmailTemplate newModelQuery()
 * @method static Builder|EmailTemplate newQuery()
 * @method static Builder|EmailTemplate onlyTrashed()
 * @method static Builder|EmailTemplate query()
 * @method static Builder|EmailTemplate whereBcc($value)
 * @method static Builder|EmailTemplate whereBody($value)
 * @method static Builder|EmailTemplate whereCreatedAt($value)
 * @method static Builder|EmailTemplate whereDeletedAt($value)
 * @method static Builder|EmailTemplate whereId($value)
 * @method static Builder|EmailTemplate whereName($value)
 * @method static Builder|EmailTemplate whereSlug($value)
 * @method static Builder|EmailTemplate whereSource($value)
 * @method static Builder|EmailTemplate whereSubject($value)
 * @method static Builder|EmailTemplate whereUpdatedAt($value)
 * @method static Builder|EmailTemplate withTrashed()
 * @method static Builder|EmailTemplate withoutTrashed()
 * @mixin Eloquent
 */
class EmailTemplate extends BaseModel
{
    protected $guarded = ['id'];
}
