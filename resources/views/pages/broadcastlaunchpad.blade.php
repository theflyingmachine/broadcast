@extends('layouts.app')
@section('content')
<h1>Broadcast Launchpad</h1>
@if(count($allbroadcasts) > 0)
{{-- $allbroadcasts = explode( '|', $string ); --}}
{{-- {{$allbroadcasts}} --}}

@foreach($allbroadcasts as $broadcast)
    <div class="well">
        
            {{-- @foreach($broadcast as $prop) --}}
        <h3> {{$broadcast->name}}</h3>
        {{-- @endforeach --}}
    </div>
    @endforeach
@else
<div class="well">
    <h3> No members selected for broadcast.</h3>
</div>
@endif

@endsection