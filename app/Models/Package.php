<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Package extends  BaseModel
{
    protected $casts = [
        'details' => 'array',
    ];

    public function getDetailsAttribute($value): array
    {
        $details = json_decode($value, true); // Decode the JSON into an array

        // Map through the details to ensure `active` is a boolean
        return array_map(function ($item) {
            $item['active'] = (bool) $item['active']; // Cast 'active' to boolean
            return $item;
        }, $details);
    }
    protected $guarded = ['id'];

    public function expo(): BelongsTo
    {
        return $this->belongsTo(Expo::class);
    }

}




