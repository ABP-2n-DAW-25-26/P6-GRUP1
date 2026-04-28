<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'name',
        'primary',
        'primary-dark',
        'secondary',
        'text',
        'text-secondary',
        'background',
        'background-card',
    ];

    public $timestamps = false;
}
