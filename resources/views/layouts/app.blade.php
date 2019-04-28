<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex">
        <meta name="AdsBot-Google" content="noindex">
        <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
        <title>{{$title}}</title>        
    </head>

    <body>
        @include('includes.header')

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
