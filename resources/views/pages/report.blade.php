<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Report Generator</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('assets/css/main.css') }}">
    </head>
    <body class="page-container">
        <div class="page-header" style="text-align: end; padding-right: 20mm;">{{ $report_title }}</div>
        @include('pages.partial.images')
        <div class="page-footer">{{ $report_footer }}</div>
    </body>
</html>
