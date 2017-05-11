<?php

use Illuminate\Database\Seeder;
use App\Drawing;
use App\Gallery;

class DrawingGalleryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $drawings =[
        'sleepy bat' => ['portrait','abstract'],
        'blue bird' => ['animal','impressionist'],
        'doodlebug' => ['portrait','post-modern']
         ];
         foreach($drawings as $title => $galleries) {

            $drawing = Drawing::where('title','like',$title)->first();

            foreach($galleries as $galleryName) {
                $gallery = Gallery::where('name','LIKE',$galleryName)->first();

            # Connect this tag to this book
                $drawing->galleries()->sync($gallery);
            }

        }
    }
}
