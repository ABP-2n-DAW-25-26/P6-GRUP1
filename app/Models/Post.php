<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'activities';
    protected $fillable = ['id', 'title', 'description', 'start_date', 'end_date', 'type', 'file', 'exchange_id'];

    // public function exchange()
    // {
    //     return $this->belongsTo(Exchange::class, 'exchange_id');
    // }
}
