<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exchange extends Model
{
    protected $fillable = ['id','origin','start_date','end_date','destiny',];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'exchange_user', 'exchange_id', 'user_id');
    }
}
