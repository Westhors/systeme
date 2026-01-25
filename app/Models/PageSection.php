<?php

namespace App\Models;

use App\Traits\HasMedia;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

/**
 *
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $sub_title
 * @property string|null $post_title
 * @property string|null $short_description
 * @property string|null $description
 * @property bool|null $button_one_active
 * @property array|null $button_one
 * @property bool|null $button_two_active
 * @property array|null $button_two
 * @property array|null $divider
 * @property string|null $bg_style
 * @property bool $active
 * @property int $position
 * @property int|null $parent_id
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Collection<int, PageSection> $children
 * @property-read int|null $children_count
 * @property-read Collection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Collection<int, Page> $pages
 * @property-read int|null $pages_count
 * @property-read PageSection|null $parent
 * @method static Builder|PageSection filter($filters = null, $filterOperator = '=')
 * @method static Builder|PageSection newModelQuery()
 * @method static Builder|PageSection newQuery()
 * @method static Builder|PageSection onlyTrashed()
 * @method static Builder|PageSection query()
 * @method static Builder|PageSection whereActive($value)
 * @method static Builder|PageSection whereBgStyle($value)
 * @method static Builder|PageSection whereButtonOne($value)
 * @method static Builder|PageSection whereButtonOneActive($value)
 * @method static Builder|PageSection whereButtonTwo($value)
 * @method static Builder|PageSection whereButtonTwoActive($value)
 * @method static Builder|PageSection whereCreatedAt($value)
 * @method static Builder|PageSection whereDeletedAt($value)
 * @method static Builder|PageSection whereDescription($value)
 * @method static Builder|PageSection whereDivider($value)
 * @method static Builder|PageSection whereId($value)
 * @method static Builder|PageSection whereOrderId($value)
 * @method static Builder|PageSection whereParentId($value)
 * @method static Builder|PageSection wherePostTitle($value)
 * @method static Builder|PageSection whereShortDescription($value)
 * @method static Builder|PageSection whereSubTitle($value)
 * @method static Builder|PageSection whereTitle($value)
 * @method static Builder|PageSection whereUpdatedAt($value)
 * @method static Builder|PageSection withTrashed()
 * @method static Builder|PageSection withoutTrashed()
 * @mixin Eloquent
 */
class PageSection extends BaseModel
{
    use HasMedia;

    protected $with = [
        'media',
    ];

    protected $guarded = ['id'];

    protected $table = "page_sections";

    protected $casts = [
        'active' => 'boolean',
        'button_one_active' => 'boolean',
        'button_two_active' => 'boolean',
        'button_one' => 'array',
        'button_two' => 'array',
        'divider' => 'array',
    ];

    // public function pages(): BelongsToMany
    // {
    //     return $this->belongsToMany(Page::class, 'pages_page_sections', 'page_id', 'page_section_id')->withPivot('position')->withTimestamps();
    // }


    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(PageSection::class, 'pages_page_sections', 'page_id', 'page_section_id')
        ->withPivot(['id','page_id', 'page_section_id', 'position', 'created_at', 'updated_at'])->withTimestamps();
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }
    public function children(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }
}
