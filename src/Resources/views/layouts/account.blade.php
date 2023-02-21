<!DOCTYPE html>
<html lang="{{ $current_locale }}">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    <link rel="icon" type="image/png" href="{{ asset('front/images/favicon.png') }}"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    @livewireStyles
    @stack('css')
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>


<body class="@yield('body_class')">

<x-metaframework::bad-access/>
<main>
    @section('dashboard-nav')
        @include('front.account.dashboard.nav')
    @show
    {{ $slot }}
</main>

@stack('modals')
@livewireScripts
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="{{ asset('js/common.js') }}"></script>
<script src="{{ asset('front/js/common.js') }}"></script>
<script src="{{ asset('front/js/dashboard.js') }}"></script>

@stack('callbacks')
@stack('js')
<script>
    $(function() {
        $(".progress-circle").loading();
    });
</script>
</body>
</html>
