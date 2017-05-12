@extends('layouts.master')

@push('head')
    <link href='/css/books.css' rel='stylesheet'>
    <style>
      .floated_img
      {
        float: left;
      }
     .grid_element {
  display: inline-block;
  width: 200px;
  height:200px;
  zoom: 1;         /* for IE */
  display*:inline; /* for IE */
}

    </style>
@endpush

@section('title')
    doodleBook
@endsection

@section('content')

    <h1>Welcome, {{Auth::user()->name}}!</h1>
    <br>
    @if(empty($results))
        <h3>You do not have any drawings yet.<br> Add some by clicking on 'Add A Drawing'!</h3> 

    @else
     <meta name="csrf-token" content="{!! csrf_token() !!}">
    <form method='POST' action="/gallery_filter">
    {{ csrf_field() }}
    <label for="gallery_select">Select gallery to display: </label>
    <select id="gallery_select" name="gallery_select">
     <option value="all">all</option>
     @foreach($galleries as $key=>$value)
       <option value="{{$key}}">{{$value}}</option>
     @endforeach
    </select>
    </form>
    <br><br>
    <hr>
    <div id="table">
    @include('gallery.table')
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">
       $('#gallery_select').change(function(){
           console.log($("#gallery_select").val());
           $.ajax({
              type: "GET",
              url: "/gallery_filter",
              data: {
                   '_token': $('meta[name="csrf-token"]').attr('content')
                   ,pledge:  $(this).data('pledge') 
                   ,value: $("#gallery_select").val() 
                   },
              success: function(data){
                 console.log(data.value);
                 $('#table').html(data.html);
              }
           });
       });

    </script>
    @endif
@endsection
