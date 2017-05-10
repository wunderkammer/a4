@extends('layouts.master')

@section('title')
    Confirm deletion: {{ $drawing->title }}
@endsection

@section('content')

    <h1>Confirm deletion</h1>
    <form method='POST' action='/drawing/delete'>

        {{ csrf_field() }}

        <input type='hidden' name='id' value='{{ $drawing->id }}'?>
        <input type='hidden' name='filename' value='{{ $drawing->filename }}'?>
        <h2>Are you sure you want to delete <em>{{ $drawing->title }}</em>?</h2>

        <input type='submit' value='Yes, delete this drawing.' class='btn btn-danger'>

    </form>

@endsection
