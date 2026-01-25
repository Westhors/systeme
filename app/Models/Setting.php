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
 * @property string|null $label
 * @property string|null $placeholder
 * @property string|null $des
 * @property string $name
 * @property string|null $type
 * @property string|null $data
 * @property string|null $class
 * @property string|null $rules
 * @property string|null $value
 * @property int|null $parent_id
 * @property array|null $button
 * @property array|null $items
 * @property int|null $position
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, Setting> $children
 * @property-read int|null $children_count
 * @property-read Collection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Setting|null $parent
 * @method static Builder|Setting filter($filters = null, $filterOperator = '=')
 * @method static Builder|Setting newModelQuery()
 * @method static Builder|Setting newQuery()
 * @method static Builder|Setting onlyTrashed()
 * @method static Builder|Setting query()
 * @method static Builder|Setting whereButton($value)
 * @method static Builder|Setting whereClass($value)
 * @method static Builder|Setting whereCreatedAt($value)
 * @method static Builder|Setting whereData($value)
 * @method static Builder|Setting whereDeletedAt($value)
 * @method static Builder|Setting whereDes($value)
 * @method static Builder|Setting whereId($value)
 * @method static Builder|Setting whereItems($value)
 * @method static Builder|Setting whereLabel($value)
 * @method static Builder|Setting whereName($value)
 * @method static Builder|Setting whereOrderId($value)
 * @method static Builder|Setting whereParentId($value)
 * @method static Builder|Setting wherePlaceholder($value)
 * @method static Builder|Setting whereRules($value)
 * @method static Builder|Setting whereType($value)
 * @method static Builder|Setting whereUpdatedAt($value)
 * @method static Builder|Setting whereValue($value)
 * @method static Builder|Setting withTrashed()
 * @method static Builder|Setting withoutTrashed()
 * @mixin Eloquent
 */
class Setting extends BaseModel
{
    use HasMedia;
    protected $with = [
        'media',
    ];
    protected $guarded = ['id'];

    protected $casts = [
        'items' => 'array',
        'button' => 'array',
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
