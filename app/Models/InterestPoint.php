<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterestPoint extends Model
{
    protected $table = 'activities';    
    protected $fillable = ['id','title','description','start_date','end_date','latitude','longitude','type','file','exchange_id'];
}
