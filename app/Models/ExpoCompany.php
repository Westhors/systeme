<?php

namespace App\Models;

use App\Traits\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpoCompany extends BaseModel
{
    use HasMedia;

    protected $with = [
        'media',
    ];
    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function network(): BelongsTo
    {
        return $this->belongsTo(LogoCompany::class);
    }
    public function expo(): BelongsTo
    {
        return $this->belongsTo(Expo::class);
    }
}
