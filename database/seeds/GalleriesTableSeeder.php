<?php

use Illuminate\Database\Seeder;
use App\Gallery;


class GalleriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    $galleries = ['landscape', 'portrait', 'still life','traditional', 'abstract', 'impressionist','post-modern'];
  
     foreach($galleries as $galleryName) {
        $gallery = new Gallery();
        $gallery->name = $galleryName;
        $gallery->save();
      }
    }
}
