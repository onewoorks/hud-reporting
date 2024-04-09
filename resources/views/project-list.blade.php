<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/main.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/paper.css') }}">

    </head>
    <body class="A4">

    <section class="sheet padding-20mm">
        @foreach($report_base as $base)

            <div><a href='/project/{{ $base }}'>{{ $base}}</a></div>
        @endforeach
    </section>

   
    </body>
</html>
