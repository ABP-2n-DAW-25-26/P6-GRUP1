<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    protected $fillable = ['id','name','description','statement','answer','latitude','longitude','type','file','activity_id','order'];
        
    public function guidedActivity()
    {
        return $this->belongsTo(GuidedActivity::class, 'activity_id');
    }
}
