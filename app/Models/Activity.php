<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'latitude',
        'longitude',
        'type',
        'file',
        'exchange_id',
        'theme_id',

    ];

    public function exchange(): BelongsTo
    {
        return $this->belongsTo(Exchange::class);
    }
}
