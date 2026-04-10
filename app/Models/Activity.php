<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    ];
}
