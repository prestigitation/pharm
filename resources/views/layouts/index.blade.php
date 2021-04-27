<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>PharmCrm</title>

        <link rel="stylesheet" href=" {{ asset('css/app.css') }}">

        <script src='{{ asset('js/app.js') }}'></script>

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">


        <style>
            body {
                font-family: 'Nunito';
                height:100%;
                min-height:900px;
            }
            #app {
                height:100%;
                min-height:inherit;
            }
        </style>
    </head>
    <body>

   <div id='app'>
        <router-view>
        </router-view>
    </div>

        @stack('footer_scripts')



    </body>
</html>
