<?php

namespace App\Models;

use App\Traits\HasMedia;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;


class Page extends BaseModel
{
    use HasMedia;

    protected $guarded = ['id'];

    protected $with = [
        'media',
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function pageSections(): BelongsToMany
    {
        return $this->belongsToMany(PageSection::class, 'pages_page_sections', 'page_id', 'page_section_id')
        ->withPivot(['id','page_id', 'page_section_id', 'position', 'created_at', 'updated_at'])->withTimestamps();
    }
}
