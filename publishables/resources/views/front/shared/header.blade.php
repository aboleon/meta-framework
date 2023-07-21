<header id="header">
    <a href="{{url('/')}}">
        <img src="{{ url('media/logo.png') }}" class="logo" style="position: absolute; top: 50%;left:50%;transform:translate(-50%,-50%)">
    </a>
    {!! (new \App\Printers\Nav\BootstrapCustomNavbar('main'))() !!}
</header>
