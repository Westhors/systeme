<?php

namespace App\Models;

use App\Traits\HasMedia;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $icon
 * @property string $short_description
 * @property string $description
 * @property int|null $parent_id
 * @property string $type
 * @property int $position
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, Service> $children
 * @property-read int|null $children_count
 * @property-read Collection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Service|null $parent
 * @method static Builder|Service filter($filters = null, $filterOperator = '=')
 * @method static Builder|Service newModelQuery()
 * @method static Builder|Service newQuery()
 * @method static Builder|Service onlyTrashed()
 * @method static Builder|Service query()
 * @method static Builder|Service whereCreatedAt($value)
 * @method static Builder|Service whereDeletedAt($value)
 * @method static Builder|Service whereDescription($value)
 * @method static Builder|Service whereIcon($value)
 * @method static Builder|Service whereId($value)
 * @method static Builder|Service whereName($value)
 * @method static Builder|Service whereParentId($value)
 * @method static Builder|Service wherePosition($value)
 * @method static Builder|Service whereShortDescription($value)
 * @method static Builder|Service whereSlug($value)
 * @method static Builder|Service whereType($value)
 * @method static Builder|Service whereUpdatedAt($value)
 * @method static Builder|Service withTrashed()
 * @method static Builder|Service withoutTrashed()
 * @mixin Eloquent
 */
class Service extends BaseModel
{
    use HasMedia;

    protected $with = [
        'media',
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'parent_id' => 'integer',
        'position' => 'integer',
        'active' => 'boolean',
    ];
   
    public function parent(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }
}
