<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use App\Drawing;
use Session;
use Storage;


class GalleryController extends Controller {
    public function welcome(Request $request){
         $results = Drawing::where('public', '=', 1)->get();
         $results_array = $results->toArray();        
         return view('welcome')->with(['results'=>$results_array]);
    }
    public function index(Request $request) {
        $drawing = new Drawing();
        $user = $request->user();
        $results = Drawing::where('user_id', '=', $user['id'])->get();
        $results_array = $results->toArray();
        return view('gallery.index')->with(['results'=>$results_array]);
    }

    public function storeNewGallery(Request $request) {
        $messages = [
            'title' => 'Please provide a title.',
            'description' => 'Please provide a description.',
        ];

        # Custom error message
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ],$messages);




        if(isset($_POST['title'])){


        $drawing = new Drawing();
        $user = $request->user();
        # Set the parameters
        # Note how each parameter corresponds to a field in the table
        $drawing->title = $request->title;
        $drawing->description = $request->description;

        $drawing->user_id = $user['id'];
        $drawing->filename = $user['name'].time().".png";
        $drawing->public = 0;
        # Invoke the Eloquent `save` method to generate a new row in the
        # `books` table, with the above data
        $drawing->save();

        } else {
           dump('Not Added');
        }
        return redirect('/home');
    }
    public function createNewGallery(Request $request){
         return view('gallery.new');
    }

    public function delete() {
        return 'deletes gallery';
    }
     
    public function store(Request $request)
    {
    $user = $request->user();
    $upload_dir = storage_path().'/app/public/';
    $img = $_POST['image'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file = $upload_dir . $user['name'].time() . ".png";
    $success = file_put_contents($file, $data);
    print $success ? $file : 'Unable to save the file.';
    }
   public function storeEdit(Request $request)
    {
    $user = $request->user();
    $upload_dir = storage_path().'/app/public/';
    $img = $_POST['image'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file = $upload_dir .$request->filename;
    $success = file_put_contents($file, $data);
    print $success ? $file : 'Unable to save the file.';
    }

   
   public function editDrawing($id) {
        $drawing = Drawing::where('id','=',$id)->get();
        $results_array = $drawing->toArray();
        if(is_null($drawing)) {
            Session::flash('message', 'The drawing you requested was not found.');
            return redirect('/home');
        }
        # Results in an array like this: $tagsForThisBook => ['novel','fiction','classic'];
        return view('gallery.edit')->with([
            'id' => $id,
            'filename' => $results_array[0]['filename'],
            'title' => $results_array[0]['title'],
            'description' => $results_array[0]['description'],
            'public' => $results_array[0]['public'],
        ]);
    }
    public function edit($id) {
        $drawing = Drawing::with('tags')->find($id);
        if(is_null($drawing)) {
            Session::flash('message', 'The drawing you requested was not found.');
            return redirect('/home');
        }
        # Results in an array like this: $tagsForThisBook => ['novel','fiction','classic'];
        return view('drawing.edit')->with([
            'id' => $id, 
            'drawing' => $drawing,
            'title' => $title,
            'description' => $description,
            'public'=> $public,
        ]);
    }
     public function saveEdits(Request $request) {
         $messages = [
            'title.required' => 'Title not provided.',
            'description.required' => 'Description not provided.',
        ];
        
        # Custom error message
        $this->validate($request, [
            'title' => 'required|min:3',
            'description' => 'required|min:3',
        ], $messages);
        
        $drawing = Drawing::find($request->id);
        //$drawing = Drawing::where("id","=",$request->id)->first();
        # Edit book in the database
        if($request->public){
		$public = 1;
        }else{
       		$public = 0;
        }
        $drawing->public = $public;
        $drawing->title = $request->title;
        $drawing->description = $request->description;
        # If there were tags selected...
        if($request->tags) {
            $tags = $request->tags;
        }
        # If there were no tags selected (i.e. no tags in the request)
        # default to an empty array of tags
        else {
            $tags = [];
        }
        # Above if/else could be condensed down to this: $tags = ($request->tags) ?: [];
        # Sync tags
        $drawing->save();
        Session::flash('message', 'Your changes to '.$drawing->title.' were saved.');
        
        return redirect('/gallery');
    }
    public function deleteDrawing(Request $request) {
        # Get the book to be deleted
        $drawing = Drawing::find($request->id);
        if(!$drawing) {
            Session::flash('message', 'Deletion failed; book not found.');
            return redirect('/home');
        }
        $drawing->delete();
        # Finish
        Session::flash('message', $drawing->title.' was deleted.');
        return redirect('/home');
    }  

    public function confirmDeletion($id) {
        # Get the book they're attempting to delete
        $drawing = Drawing::find($id);
        if(!$drawing) {
            Session::flash('message', 'Book not found.');
            return redirect('/gallery');
        }
        return view('gallery.delete')->with('drawing', $drawing);
    } 
     


}
