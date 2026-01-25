<?php

namespace App\Models;

use App\Traits\HasMedia;
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
 * @property string|null $title
 * @property string|null $des
 * @property string $slug
 * @property string $type
 * @property string|null $short_des
 * @property string|null $url_text
 * @property string|null $url_path
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property int|null $delegates
 * @property int|null $sessions
 * @property int|null $companies
 * @property int|null $countries
 * @property bool $featured
 * @property int|null $position
 * @property bool $active
 * @property string|null $city
 * @property int|null $duration
 * @property string|null $venue
 * @property int|null $country_id
 * @property int|null $user_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Country|null $country
 * @property-read Collection<int, Media> $media
 * @property-read int|null $media_count
 * @method static Builder|Event filter($filters = null, $filterOperator = '=')
 * @method static Builder|Event newModelQuery()
 * @method static Builder|Event newQuery()
 * @method static Builder|Event onlyTrashed()
 * @method static Builder|Event query()
 * @method static Builder|Event whereActive($value)
 * @method static Builder|Event whereCity($value)
 * @method static Builder|Event whereCompanies($value)
 * @method static Builder|Event whereCountries($value)
 * @method static Builder|Event whereCountryId($value)
 * @method static Builder|Event whereCreatedAt($value)
 * @method static Builder|Event whereDelegates($value)
 * @method static Builder|Event whereDeletedAt($value)
 * @method static Builder|Event whereDes($value)
 * @method static Builder|Event whereDuration($value)
 * @method static Builder|Event whereEndDate($value)
 * @method static Builder|Event whereFeatured($value)
 * @method static Builder|Event whereId($value)
 * @method static Builder|Event whereOrderId($value)
 * @method static Builder|Event whereSessions($value)
 * @method static Builder|Event whereShortDes($value)
 * @method static Builder|Event whereSlug($value)
 * @method static Builder|Event whereStartDate($value)
 * @method static Builder|Event whereTitle($value)
 * @method static Builder|Event whereType($value)
 * @method static Builder|Event whereUpdatedAt($value)
 * @method static Builder|Event whereUrlPath($value)
 * @method static Builder|Event whereUrlText($value)
 * @method static Builder|Event whereUserId($value)
 * @method static Builder|Event whereVenue($value)
 * @method static Builder|Event withTrashed()
 * @method static Builder|Event withoutTrashed()
 * @mixin Eloquent
 */
class Event extends BaseModel
{
    use HasMedia;

    protected $with = [
        'media',
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'active' => 'boolean',
        'featured' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
