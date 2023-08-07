<!doctype html>
<html lang="fr-FR">
<head>
    <title>{{ config('app.name') }} - @yield('meta')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    @stack('css')
</head>

<body>

{{ $slot }}

</body>
</html>
