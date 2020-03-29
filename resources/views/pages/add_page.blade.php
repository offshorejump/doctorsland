@extends('layouts.default')
@section('title', 'add page')
@section('content')


    @foreach($userlist as $items)

        <h2>{{$items->name}}</h2>
    @endforeach
@stop
