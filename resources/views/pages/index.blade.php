@extends('layouts.app')


@section('content')
<h1>All your Broadcasts till date </h1>
@if(count($allbroadcasts) > 0)
    @foreach($allbroadcasts as $broadcast)
    <div class="well">
        <h3> <a href="/viewresponse/{{$broadcast->b_id}}">{{$broadcast->b_id}}</h3>
    </div>
    @endforeach
@else
    <p>No Broadcasts yet...</p>
@endif

@endsection