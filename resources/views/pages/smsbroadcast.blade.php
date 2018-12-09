@extends('layouts.app')
@section('content')
<h1>Start New SMS broadcast </h1> <br><br><br>
<form id="frm-example" action="/smsbroadcaststaging" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
@include('inc.checkboxTable')


<hr>
<div class="card indigo text-center z-depth-2 light-version py-4 px-5">

<div class="form-group shadow-textarea">
    <label for="exampleFormControlTextarea6">Enter your text</label>
    <textarea class="form-control z-depth-1" id="smstext" name="smstext" rows="3" placeholder="Write something here..." required></textarea>
  </div>
<hr>
<input class="form-control form-control-lg" type="text" id="title" name="title" placeholder="Broadcast Title" required>
<hr>
<p>Press <b>Staging</b> and validate console for broadcast.</p>

<p><button type="submit" class="btn btn-block btn-warning" >Staging</button></p>
</div>

</form>


@endsection
