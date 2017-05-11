<?php

use Illuminate\Database\Seeder;

use App\Drawing;

class DrawingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Drawing::insert([
        'created_at' => Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
        'title' => 'funky bird',
        'description' => 'rockin robin',
        'filename' => 'seeder_image.png',
        'public' => 1,
        'user_id' => 2,
        ]);
        Drawing::insert([
        'created_at' => Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
        'title' => 'punk parrot',
        'description' => 'jive turkey',
        'filename' => 'seeder_image.png',
        'public' => 0,
        'user_id' => 2,
        ]);
        Drawing::insert([
        'created_at' => Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
        'title' => 'blue bird',
        'description' => 'jazzy chirping',
        'filename' => 'seeder_image.png',
        'public' => 0,
        'user_id' => 2,
        ]);
        Drawing::insert([
        'created_at' => Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
        'title' => 'chicken little',
        'description' => 'sky falling',
        'filename' => 'seeder_image.png',
        'public' => 0,
        'user_id' => 2,
        ]);
     
    }
}
