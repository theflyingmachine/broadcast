<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
        {{-- application icon --}}
        <link rel="shortcut icon" href="{{ asset('image/broadicon.png') }}">
        {{-- For CSRF protection --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- //Css for well --}}
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- <title>{{config('app.name', 'Broadcast')}}</title> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <title>Broadcast</title>
        <style>
            .card.light-version .file-field input[type=text] {
              border-bottom: 1px solid #fff; }
              .card.light-version .file-field input[type=text]::-webkit-input-placeholder {
                color: #fff;
                font-weight: 300; }
              .card.light-version .file-field input[type=text]::-moz-placeholder {
                color: #fff;
                font-weight: 300; }
              .card.light-version .file-field input[type=text]:-ms-input-placeholder {
                color: #fff;
                font-weight: 300; }
              .card.light-version .file-field input[type=text]::placeholder {
                color: #fff;
                font-weight: 300; }
              .card.light-version .file-field input[type=text]:focus:not([readonly]) {
                -webkit-box-shadow: 0 1px 0 0 #fff;
                box-shadow: 0 1px 0 0 #fff; }
              .card.light-version .file-field input[type=text].valid {
                border-bottom: 1px solid #00c851;
                -webkit-box-shadow: 0 1px 0 0 #00c851;
                box-shadow: 0 1px 0 0 #00c851; }
              .card.light-version .file-field input[type=text]:focus.valid {
                border-bottom: 1px solid #00c851;
                -webkit-box-shadow: 0 1px 0 0 #00c851;
                box-shadow: 0 1px 0 0 #00c851; }
                </style>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                
        </head>
    <body>
            @if(session()->has('login'))
            @include('inc.navbar')
            @endif
        
            <div class="container">
                @yield('content')
            </div>
            @if(session()->has('login'))
            @include('inc.footer')
            @endif
    </body>
</html>
