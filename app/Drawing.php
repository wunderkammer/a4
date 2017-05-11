<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drawing extends Model
{
    public function user() {
       return $this->belongsTo('App\User');
    }
    public function galleries()
    {
       return $this->belongsToMany('App\Gallery')->withTimestamps();
    }
}
