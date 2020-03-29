@extends('layouts.layout')
@section('title', 'Unauthorized Access')

@section('breadcrumbs', '<li class="active">Unauthorized Access</li>')

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

@stop