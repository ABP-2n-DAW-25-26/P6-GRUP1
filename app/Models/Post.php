<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $table = 'activities';
    protected $fillable = ['id', 'title', 'description', 'start_date', 'end_date', 'type', 'file', 'exchange_id'];

    public function images(): HasMany
    {
        return $this->hasMany(ActivityImage::class, 'activity_id');
    }

    // public function exchange()
    // {
    //     return $this->belongsTo(Exchange::class, 'exchange_id');
    // }
}
