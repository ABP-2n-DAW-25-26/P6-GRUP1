<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'name',
        'primary',
        'primary_dark',
        'secondary',
        'text',
        'text_secondary',
        'background',
        'background_card',
    ];

    public $timestamps = false;
}
