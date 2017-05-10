{{-- /resources/views/books/new.blade.php --}}
@extends('layouts.master')

@section('title')
    New book
@endsection

@push('head')
    <link href='/css/books.css' rel='stylesheet'>
    <style>
     .main {  
       text-align:center;	
     }
       
.colorPicker { 
  font-size:25px; 
  line-height:27px;} 
  
  

    </style>
@endpush


@section('content')
<div class="main">
    <h1>Create your masterpiece, {{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}!</h1>
    <canvas id="drawingCanvas" width="550" height="450" style="border:1pt solid black;margin:auto;cursor:crosshair;clear:both;">
</canvas>
<br>
<div style="display:inline-block">Colors:  </div> 
<a class="colorPicker" href="#" onclick="setColor('#000');return false;" style="background:#000;">&nbsp;&nbsp;&nbsp;</a>
<a class="colorPicker" href="#" onclick="setColor('#FF0000');return false;" style="background:#FF0000;">&nbsp;&nbsp;&nbsp;</a>
<a class="colorPicker" href="#" onclick="setColor('#00FF00');return false;" style="background:#00FF00;">&nbsp;&nbsp;&nbsp;</a>
<a class="colorPicker" href="#" onclick="setColor('#0000FF');return false;" style="background:#0000FF;">&nbsp;&nbsp;&nbsp;</a>
<a class="colorPicker" href="#" onclick="setColor('#FFFF00');return false;" style="background:#FFFF00;">&nbsp;&nbsp;&nbsp;</a>
<a class="colorPicker" href="#" onclick="setColor('#00FFFF');return false;" style="background:#00FFFF;">&nbsp;&nbsp;&nbsp;</a>

<div style="clear:both;">&nbsp;</div>

<div style="display:inline-block;">Brush Sizes:  </div> 
<a href="#" class="colorPicker" onclick="setSize(2);return false;" style="background:#000;width:2px;height:2px;margin-left:1px;">&nbsp;</a>
<a href="#" class="colorPicker" onclick="setSize(5);return false;" style="background:#000;width:5px;height:5px;margin-left:1px;">&nbsp;&nbsp;</a>
<a href="#" class="colorPicker" onclick="setSize(10);return false;" style="background:#000;width:10px;height:10px;margin-left:1px;">&nbsp;&nbsp;&nbsp;</a>
<a href="#" class="colorPicker" onclick="setSize(25);return false;" style="background:#000;width:25px;height:25px;margin-left:1px;">&nbsp;&nbsp;&nbsp;&nbsp;</a>

<div style="clear:both;">&nbsp;</div>
   <meta name="csrf-token" content="{!! csrf_token() !!}">

<p style="clear:both;"><input class='btn btn-primary' type="button" value="Clear Canvas" onclick="clearCanvas();">
    <form method='POST' action='/gallery/new'>
        {{ csrf_field() }}
        <small>* Required fields</small>
        <br>
        <label for='title'>* Title</label>
        <input type='text' name='title' id='title' value=''>
        <br>
        <label for='description'>* Description</label>
        <input type='text' name='description' id='description' value=''>
        <br>
        <input type="checkbox" checked="checked" name="public" value="1">Public
        <br><br>
        <input class='btn btn-primary' type='submit' value='Save new drawing' onclick="saveImage();">
    </form>
</div>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
 <script src="/js/foobooks.js"></script>
<script type="text/javascript">

/* Some global initializations follow. The first 2 arays will store all mouse positions 
on X and Y, the 3rd one stores the dragged positions. 
The variable paint is a boolean, and then follow the default values 
which we use to start */
var clickX = new Array();
var clickY = new Array();
var clickDrag = new Array();
var paint;
var defaultColor="#000";
var defaultShape="round";
var defaultWidth=5;

// creating the canvas element
var canvas = document.getElementById('drawingCanvas');

if(canvas.getContext) 
{
    // Initaliase a 2-dimensional drawing context
    var context = canvas.getContext('2d');
    
    // set the defaults
    context.strokeStyle = defaultColor;
    context.lineJoin = defaultShape;
    context.lineWidth = defaultWidth;
}

// binding events to the canvas
$('#drawingCanvas').mousedown(function(e){
  var mouseX = e.pageX - this.offsetLeft;
  var mouseY = e.pageY - this.offsetTop;
  
  paint = true; // start painting
  addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop);

  // always call redraw
  redraw();
});

$('#drawingCanvas').mousemove(function(e){
  if(paint){
    addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
    redraw();
  }
});

// when mouse is released, stop painting, clear the arrays with dots
$('#drawingCanvas').mouseup(function(e){
  paint = false;
  
  clickX = new Array();
  clickY = new Array();
  clickDrag = new Array();
});

// stop painting when dragged out of the canvas
$('#drawARobot').mouseleave(function(e){
  paint = false;
});

// The function pushes to the three dot arrays
function addClick(x, y, dragging)
{
  clickX.push(x);
  clickY.push(y);
  clickDrag.push(dragging);
}

// this is where actual drawing happens
// we add dots to the canvas
function redraw(){
    
  for(var i=0; i < clickX.length; i++)
  {  
    context.beginPath();
    if(clickDrag[i] && i){
      context.moveTo(clickX[i-1], clickY[i-1]);
     }else{
       context.moveTo(clickX[i]-1, clickY[i]);
     }
     context.lineTo(clickX[i], clickY[i]);
     context.closePath();
     context.stroke();
  }
}

// this is called when "clear canvas" button is pressed
function clearCanvas()
{
    // both these lines are required to clear the canvas properly in all browsers
    context.clearRect(0,0,canvas.width,canvas.height);
    canvas.width = canvas.width;
    
    // we need to flush the arrays too
    clickX = new Array();
    clickY = new Array();
    clickDrag = new Array();
}

/* Two simple functions, they just assign the selected color and size 
to the canvas object properties */ 
function setColor(col)
{
    context.strokeStyle = col;
}

function setSize(px)
{
    context.lineWidth=px;
}

/* Finally this will send your image to the server-side script which will 
save it to the database or where ever you want it saved.
Note that this function should be called when the button in your save 
form is pressed. The variable frm is the form object. 
Basically the HTML will look like this:
<input type="button" value="Save Drawing" onclick="saveDrawing();">
 */
function saveDrawing()
{       
    // converting the canvas to data URI
    var canvasData = canvas.toDataURL("image/png");  
    alert(canvasData);
    var ajax = new XMLHttpRequest();
    ajax.open("POST",'/',false);
    ajax.setRequestHeader('Content-Type', 'application/upload');
    ajax.send(canvasData );    

    
}



    

</script>

<script type="text/javascript">

function saveImage() {
     var dataURL = canvas.toDataURL();
     $.ajax({
  type: "POST",
  url: "/save-img",
  data: {
     '_token': $('meta[name="csrf-token"]').attr('content')
     ,pledge:  $(this).data('pledge') 
     ,imgBase64: dataURL
     ,image: dataURL
  }
}).done(function(o) {
  console.log('saved'); 
  // If you want the file to be visible in the browser 
  // - please modify the callback in javascript. All you
  // need is to return the url to the file, you just saved 
  // and than put the image in your browser.
});
}


</script>

@endsection
