@extends('layouts.app')

@section('content')
<h1>THis is the about Page </h1>
<p>THis is a paragraph</p>

@if(Session::has('login'))
Logged in
@else 
Logged out
@endif

@endsection