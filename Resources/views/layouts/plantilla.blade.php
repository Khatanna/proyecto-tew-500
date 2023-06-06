<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Styles -->
    @vite(['resources/js/app.js', 'resources/css/app.scss'])

    @yield('styles')
</head>

<body>
@yield('content')

@yield('scripts')
</body>

</html>

