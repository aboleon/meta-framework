<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="ajax-route" content="{{ route("ajax") }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {!! csscrush_tag(public_path('css/panel.css')) !!}

    @stack('css')


</head>
<body class="nav-md">
<div class="container body">

    <div class="col-md-3 left_col bg-white">
        <div class="left_col scroll-view sticky-top">
            <div class="navbar nav_title" style="border: 0;">
                @section('navigation-vertical')
                    @include('panel.navigation-vertical')
                @show
            </div>
        </div>
    </div>
    <div class="right_col">
        <div id="topbar" class="sticky-top bg-white shadow-sm rounded pe-2 ps-4 mb-4 d-flex justify-content-between align-items-center">

            <div class="d-flex justify-content-between">
                @if (isset($header))
                    {{ $header }}
                @else
                    @yield('slot_header')
                @endif
            </div>
            @include('panel.navbar')
        </div>

        @section('messages')
            {{-- <x-aboleon-framework::response-messages/> --}}
        @show
        <main>
            @if (isset($slot))
                {{ $slot }}
            @else
                @yield('slot')
            @endif
        </main>

    </div>
</div>
@stack('modals')


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="{{ asset('vendor/aboleon/framework/js/gentellela.js') }}"></script>
<script src="{!! asset('vendor/aboleon/framework/js/common.js') !!}"></script>
@stack('callbacks')
@stack('js')
</body>
</html>
