<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationUserAnswer extends Model
{
    protected $fillable = [
        'user_id',
        'location_id',
        'answer',
        'is_correct',
        'answered_at',
    ];
}