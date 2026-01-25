<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property int|null $position
 * @property bool $active
 * @property int $country_id
 * @property string|null $lat
 * @property string|null $lng
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Country $country
 * @method static Builder|City filter($filters = null, $filterOperator = '=')
 * @method static Builder|City newModelQuery()
 * @method static Builder|City newQuery()
 * @method static Builder|City onlyTrashed()
 * @method static Builder|City query()
 * @method static Builder|City whereActive($value)
 * @method static Builder|City whereCountryId($value)
 * @method static Builder|City whereCreatedAt($value)
 * @method static Builder|City whereDeletedAt($value)
 * @method static Builder|City whereId($value)
 * @method static Builder|City whereLat($value)
 * @method static Builder|City whereLng($value)
 * @method static Builder|City whereName($value)
 * @method static Builder|City whereOrderId($value)
 * @method static Builder|City whereUpdatedAt($value)
 * @method static Builder|City withTrashed()
 * @method static Builder|City withoutTrashed()
 * @mixin Eloquent
 */
class City extends BaseModel
{
    protected $guarded = ['id'];


    protected $casts = [
        'active' => 'boolean'
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
