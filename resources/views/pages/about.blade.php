@extends('layouts.app')

@section('content')
<h1>Work Plan</h1>
<p>Broadcast has ablity to customise bellow mentioned four fields, please make sure the fields which needs to be customised are in respective format in template.
<br>
<br>Name - [myName]
<br>Email - [myEmail]
<br>Mobile Number - [myNumber]
<br>Token - [myToken]
</p>

@if(Session::has('login'))
Logged in
@else 
Logged out
@endif

@endsection