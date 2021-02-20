<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href=" {{ asset('css/app.css') }}">

    <script src='{{ asset('js/app.js') }}'></script>

    <title>Dashboard</title>
</head>
<body>
    <div id="dashboard">
        <dashboard-component> </dashboard-component>
    </div>

</body>
</html>
