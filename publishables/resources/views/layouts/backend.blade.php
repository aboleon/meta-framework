<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('media/favicon') }}/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('media/favicon') }}/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('media/favicon') }}/favicon-16x16.png">
    <link rel="manifest" href="{{ asset('media/favicon') }}/site.webmanifest">
    <link rel="mask-icon" href="{{ asset('media/favicon') }}/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    {!! csscrush_tag(public_path('css/panel.css')) !!}

    @livewireStyles
    @stack('css')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="nav-md">
<x-jet-banner/>
<div class="container body">

    <div class="col-md-3 left_col bg-white">
        <div class="left_col scroll-view sticky-top">
            <div class="navbar nav_title" style="border: 0;">
                @section('navigation-vertical')
                    @include('navigation-vertical')
                @show
            </div>
        </div>
    </div>
    <div class="right_col" role="main">
        <div id="topbar" class="sticky-top bg-white shadow-sm rounded px-4 py-2 mb-4">
            @include('panel.navbar')
            <div class="d-flex justify-content-between">
                @if (isset($header))
                    {{ $header }}
                @else
                    @yield('slot_header')
                @endif
            </div>
        </div>

        @section('messages')
            <x-mfw::response-messages/>
        @show

        <div id="main">
            @if (isset($slot))
                {{ $slot }}
            @else
                @yield('slot')
            @endif
        </div>
    </div>
</div>
@stack('modals')

@livewireScripts

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="{{ asset('vendor/mfw/js/gentellela.js') }}"></script>
<script src="{!! asset('vendor/mfw/js/common.js') !!}"></script>
@stack('callbacks')
@stack('js')
</body>
</html>
