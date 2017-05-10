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
    Books
@endsection

@section('content')

    <h1>Welcome {{Auth::user()->name}}</h1>
    @foreach($results as $k => $v)
    @foreach ($v as $key => $value)
        <div class="floated_img"> 
        @if ($key == 'filename') 
        <img width="100px" src="/storage/{{$value}}">
        @endif
        @if ($key == 'title')
        <p>
           {{$value}}
        </p>
        @endif
        @if ($key == 'id')
          <a href="/drawing/edit/{{$value}}" >edit</a>
          <a href="/drawing/delete/{{$value}}" >delete</a>
        @endif
        </div>
    @endforeach
    @endforeach 
@endsection
