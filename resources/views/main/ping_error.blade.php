@extends('layouts.base')

@section('content')

<div class="container">
    <div class="jumbotron">
        <h1>{{$title}}</h1>
        <p>Airline page is temporarily unavailable!</p>
        <p>Try refreshing the page in a couple of minutes.</p>
        <p>
            <a class="btn btn-primary btn-lg" href="{{route('index')}}" role="button">Refresh</a>
        </p>
    </div>
</div>


@endsection