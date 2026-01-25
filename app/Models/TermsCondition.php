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
 * @method static Builder|TermsCondition filter($filters = null, $filterOperator = '=')
 * @method static Builder|TermsCondition newModelQuery()
 * @method static Builder|TermsCondition newQuery()
 * @method static Builder|TermsCondition onlyTrashed()
 * @method static Builder|TermsCondition query()
 * @method static Builder|TermsCondition whereActive($value)
 * @method static Builder|TermsCondition whereCreatedAt($value)
 * @method static Builder|TermsCondition whereDeletedAt($value)
 * @method static Builder|TermsCondition whereDescription($value)
 * @method static Builder|TermsCondition whereId($value)
 * @method static Builder|TermsCondition wherePosition($value)
 * @method static Builder|TermsCondition whereSlug($value)
 * @method static Builder|TermsCondition whereTitle($value)
 * @method static Builder|TermsCondition whereUpdatedAt($value)
 * @method static Builder|TermsCondition withTrashed()
 * @method static Builder|TermsCondition withoutTrashed()
 * @mixin Eloquent
 */
class TermsCondition extends BaseModel
{
    protected $guarded = ['id'];
    protected $casts = [
        'active' => 'boolean',
    ];
}
