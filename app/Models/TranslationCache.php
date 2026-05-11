<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranslationCache extends Model
{
    protected $fillable = ['lang', 'url', 'original', 'translated'];
}
