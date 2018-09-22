@extends('layouts.app')
@section('content')
<h1>Broadcast Launchpad</h1>
@if(count($allbroadcasts) > 0)
{{-- $allbroadcasts = explode( '|', $string ); --}}
{{-- {{$allbroadcasts}} --}}
<button type="button" id="button1" class="btn btn-success btn-lg btn-block"> Broadcast </button>


          <p>&nbsp;</p>
          <p>&nbsp;</p>
          <div id="progressbar" style="border:1px solid #ccc; border-radius: 5px; "></div>
    
          <!-- Progress information -->
          <br>
          <div id="information" ></div>
  
  <iframe id="loadarea" style="display:none;"></iframe><br />
  <script >
	$("#button1").click(function(){
		document.getElementById('loadarea').src = 'progressbar.php';
	});
	$("#button2").click(function(){
		document.getElementById('loadarea').src = '';
	});
</script>
<hr>
<br>
<div class="card-columns">
@foreach($allbroadcasts as $broadcast)
    

    <div class="card">
      <img class="card-img-top" src="https://www.lanserhof.com/thumbs/hamburg/standort_medicum-350x180.jpg" alt="Card image cap">
      <div class="card-body">
        <h4 class="card-title">{{$broadcast->name}}</h4>
        <p class="card-text">{{$broadcast->email}}</p>
      </div>
      <div class="card-footer">
        <small class="text-muted">{{$broadcast->token}}</small>
      </div>
    </div>

@endforeach
</div>
@else
<div class="well">
    <h3> No members selected for broadcast.</h3>
</div>
@endif

@endsection