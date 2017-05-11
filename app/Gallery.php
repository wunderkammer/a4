<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public function drawings() {
        return $this->belongsToMany('App\Drawing')->withTimestamps();
    }
    public static function getGalleriesForDropdown() {

 	   $galleries = Gallery::orderBy('name','ASC')->get();

    	   $galleriesForDropdown = [];

           foreach($galleries as $gallery) {
               $galleriesForDropdown[$gallery['id']] = $gallery->name;
            }

           return $galleriesForDropdown;
 
    }
}
