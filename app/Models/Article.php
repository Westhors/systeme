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
 * @property string|null $name
 * @property string|null $slug
 * @property string|null $short_des
 * @property string|null $des
 * @property int|null $position
 * @property bool $active
 * @property bool $featured
 * @property Carbon $publish_date
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, Media> $media
 * @property-read int|null $media_count
 * @method static Builder|Article filter($filters = null, $filterOperator = '=')
 * @method static Builder|Article newModelQuery()
 * @method static Builder|Article newQuery()
 * @method static Builder|Article onlyTrashed()
 * @method static Builder|Article query()
 * @method static Builder|Article whereActive($value)
 * @method static Builder|Article whereCreatedAt($value)
 * @method static Builder|Article whereDeletedAt($value)
 * @method static Builder|Article whereDes($value)
 * @method static Builder|Article whereFeatured($value)
 * @method static Builder|Article whereId($value)
 * @method static Builder|Article whereName($value)
 * @method static Builder|Article whereOrderId($value)
 * @method static Builder|Article wherePublishDate($value)
 * @method static Builder|Article whereShortDes($value)
 * @method static Builder|Article whereSlug($value)
 * @method static Builder|Article whereUpdatedAt($value)
 * @method static Builder|Article withTrashed()
 * @method static Builder|Article withoutTrashed()
 * @mixin Eloquent
 */
class Article extends BaseModel
{
    use HasMedia;

    protected $with = [
        'media',
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'active' => 'boolean',
        'featured' => 'boolean',
        'publish_date' => 'datetime'
    ];
}
