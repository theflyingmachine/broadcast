@extends('layouts.app')
@section('content')
<h1>Start New broadcast </h1> </br></br></br>
<form id="frm-example" action="/broadcaststaging" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
@include('inc.checkboxTable')


<hr>
<div class="card indigo text-center z-depth-2 light-version py-4 px-5">
Select Template to upload:
<div class="file-field">
<input type="file" name="broadcastTemplate" id="broadcastTemplate">
</div>
<hr>
<input class="form-control form-control-lg" type="text" id="title" name="title" placeholder="Broadcast Title" required>
<hr>
<p>Press <b>Staging</b> and validate console for broadcast.</p>

<p><button type="submit" class="btn btn-block btn-warning" disabled >Staging</button></p>
</div>

</form>

<script>
    $(document).ready(
    function(){
        $('input:file').change(
            function(){
                if ($(this).val()) {
                    $('button:submit').attr('disabled',false);
                    // or, as has been pointed out elsewhere:
                    // $('input:submit').removeAttr('disabled'); 
                } 
            }
            );
    });
    </script>
@endsection
