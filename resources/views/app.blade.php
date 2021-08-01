<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>
        
        <link href={{ mix('/css/app.css') }} rel="stylesheet">
    </head>
    <body>
        <div id="app"></div>
        {{-- defer를 붙여주면 스크립트파일 로딩이 백그라운드로 실행됨 --}}
        <script src="{{ mix('/js/app.js') }}" defer></script>
    </body>
</html>
