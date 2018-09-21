<html><head><title>Response</title>
<style>
body, html {
    overflow-x: hidden;
    height: 100%;
    background-image: url('https://www.mediamutation.com/wp-content/uploads/2017/07/Download-Beautiful-Full-HD-Background-Free.jpg');
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
::-webkit-scrollbar { 
    display: none; 
}
</style></head>
<body>
@if( ! empty($token['token']))
@if(count($token) == 1)

        @if($token->status=='pending')
        {{-- Status is pending - Accept responce --}}
        @include('inc.newresponse')
            {{-- <div class="well">
                <h3> <a href=/response/>{{$token->status}}</h3>
            </div> --}}
        @else
        {{-- Status is not pending, Show thankyou --}}
        @include('inc.okresponse')

    @endif 
@endif  
@else
{{-- Invalid Token --}}
@include('inc.invalidresponse')

@endif

</body></html>