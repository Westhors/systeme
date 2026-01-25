<?php

namespace App\Models;

use App\Traits\HasMedia;
use Database\Factories\CountryFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $key
 * @property string|null $code
 * @property string|null $icon
 * @property int|null $position
 * @property bool $active
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 * @method static CountryFactory factory($count = null, $state = [])
 * @method static Builder|Country filter($filters = null, $filterOperator = '=')
 * @method static Builder|Country newModelQuery()
 * @method static Builder|Country newQuery()
 * @method static Builder|Country onlyTrashed()
 * @method static Builder|Country query()
 * @method static Builder|Country whereActive($value)
 * @method static Builder|Country whereCode($value)
 * @method static Builder|Country whereCreatedAt($value)
 * @method static Builder|Country whereDeletedAt($value)
 * @method static Builder|Country whereIcon($value)
 * @method static Builder|Country whereId($value)
 * @method static Builder|Country whereKey($value)
 * @method static Builder|Country whereName($value)
 * @method static Builder|Country whereOrderId($value)
 * @method static Builder|Country whereUpdatedAt($value)
 * @method static Builder|Country withTrashed()
 * @method static Builder|Country withoutTrashed()
 * @mixin Eloquent
 */
class Country extends BaseModel
{
    use HasFactory;
    use HasMedia;

    protected $with = [
        'media',
    ];

    protected $guarded = ['id'];


    protected $casts = [
        'active' => 'boolean'
    ];
    protected static function newFactory(): CountryFactory
    {
        return CountryFactory::new();
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
