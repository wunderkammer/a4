<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'GalleryController@welcome');


Route::get('/gallery', 'GalleryController@index');
Route::post('/gallery', 'GalleryController@index');
Route::get('/gallery_filter', 'GalleryController@gallery_filter');
Route::post('/gallery_filter', 'GalleryController@gallery_filter');
Route::group(['middleware' => 'auth'], function () {
Route::get('/gallery/new', 'GalleryController@createNewGallery');
Route::post('/gallery/new', 'GalleryController@storeNewGallery');
Route::post('/gallery/delete', 'GalleryController@delete');
//Route::post('/gallery/store', 'GalleryController@store');
Route::post('/save-img', 'GalleryController@store');
Route::post('/save-img-edit', 'GalleryController@storeEdit');
Route::get('/drawing/edit/{id?}', 'GalleryController@editDrawing');
Route::post('/drawing/edit/', 'GalleryController@saveEdits');
Route::get('/drawing/delete/{id?}', 'GalleryController@confirmDeletion');
Route::post('/drawing/delete/', 'GalleryController@deleteDrawing');
});
Route::get('/debug', function() {

	echo '<pre>';

	echo '<h1>Environment</h1>';
	echo App::environment().'</h1>';

	echo '<h1>Debugging?</h1>';
	if(config('app.debug')) echo "Yes"; else echo "No";

	echo '<h1>Database Config</h1>';
    	echo 'DB defaultStringLength: '.Illuminate\Database\Schema\Builder::$defaultStringLength;
    	/*
	The following commented out line will print your MySQL credentials.
	Uncomment this line only if you're facing difficulties connecting to the database and you
        need to confirm your credentials.
        When you're done debugging, comment it back out so you don't accidentally leave it
        running on your production server, making your credentials public.
        */
	//print_r(config('database.connections.mysql'));

	echo '<h1>Test Database Connection</h1>';
	try {
		$results = DB::select('SHOW DATABASES;');
		echo '<strong style="background-color:green; padding:5px;">Connection confirmed</strong>';
		echo "<br><br>Your Databases:<br><br>";
		print_r($results);
	}
	catch (Exception $e) {
		echo '<strong style="background-color:crimson; padding:5px;">Caught exception: ', $e->getMessage(), "</strong>\n";
	}

	echo '</pre>';

});

if(App::environment('local')) {

    Route::get('/drop', function() {

        $db = Config::get('database.connections.mysql.database');
        
        DB::statement('DROP database '.$db);
        DB::statement('CREATE database '.$db);

        return 'Dropped '.$db.'; created '.$db.'.';
    });

};

Auth::routes();
Route::get('/home', 'GalleryController@index')->name('home');
