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
    <table cellpadding="10" style="margin:auto;">
    <th>Action</th>
    <th>Title</th>
    <th>Thumbnail image</th>
    @foreach($results as $k => $v)
       <tr>
    @foreach ($v as $key => $value)
        
        @if ($key == 'filename') 
        <td>
        <img width="100px" src="/storage/{{$value}}">
        </td>
        @endif
        @if ($key == 'title')
        <td>
           {{$value}}
        </td>
        @endif
        @if ($key == 'id')
          <td>
          <a href="/drawing/edit/{{$value}}" >edit</a>
          <br>
          <a href="/drawing/delete/{{$value}}" >delete</a>
          </td>
        @endif
        
    @endforeach
       </tr>
    @endforeach 
    </table>
@endsection
