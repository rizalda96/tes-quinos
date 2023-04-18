<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="root-text-sm">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>tes</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Inline scripts, please don't add partial script in this sections -->
    <div id="app">
        {{-- <main-app></main-app> --}}
        {{-- <example-component></example-component> --}}
        <router-view></router-view>
    </div>
    <!-- Scripts -->
    @routes
    <script src="{{ mix('js/app.js') }}"></script>

</body>

</html>
