<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>PharmCrm</title>

        <link rel="stylesheet" href=" {{ asset('css/app.css') }}">

        <script src='{{ asset('js/app.js') }}'></script>


        <style>
            body {
                font-family: 'Nunito';
            }
        </style>
    </head>
    <body>

    <script type="text/javascript">
            if(sessionStorage.getItem('status') == undefined && sessionStorage.getItem('title') == undefined && sessionStorage.getItem('message') == undefined)
                sessionStorage.clear();
    </script>

   <div id='app'>

        <router-view>
            <header-component></header-component>

        </router-view>


    </div>
        @stack('footer_scripts')
    </body>
</html>
