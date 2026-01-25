<?php

namespace App\Models;

use App\Traits\HasMedia;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $link
 * @property string|null $des
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, Media> $media
 * @property-read int|null $media_count
 * @method static Builder|Partner filter($filters = null, $filterOperator = '=')
 * @method static Builder|Partner newModelQuery()
 * @method static Builder|Partner newQuery()
 * @method static Builder|Partner onlyTrashed()
 * @method static Builder|Partner query()
 * @method static Builder|Partner whereActive($value)
 * @method static Builder|Partner whereCreatedAt($value)
 * @method static Builder|Partner whereDeletedAt($value)
 * @method static Builder|Partner whereDes($value)
 * @method static Builder|Partner whereId($value)
 * @method static Builder|Partner whereLink($value)
 * @method static Builder|Partner whereName($value)
 * @method static Builder|Partner whereUpdatedAt($value)
 * @method static Builder|Partner withTrashed()
 * @method static Builder|Partner withoutTrashed()
 * @mixin Eloquent
 */
class Partner extends BaseModel
{
    use HasMedia;

    protected $with = [
        'media',
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'active' => 'boolean',
    ];
}
