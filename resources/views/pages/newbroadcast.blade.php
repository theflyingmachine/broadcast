@extends('layouts.app')
@section('content')
<h1>Start New broadcast </h1> </br></br></br>
<form id="frm-example" action="/broadcaststaging" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
@include('inc.checkboxTable')


<hr>


Select Template to upload:
<input type="file" name="broadcastTemplate" id="broadcastTemplate">

<hr>
<p>Press <b>Submit</b> and check console for URL-encoded form data that would be submitted.</p>

<p><button type="submit">Submit</button></p>

{{-- <p><b>Selected rows data:</b></p>
<pre id="example-console-rows"></pre>

<p><b>Form data as submitted to the server:</b></p>
<pre id="example-console-form"></pre> --}}

</form>

@endsection
