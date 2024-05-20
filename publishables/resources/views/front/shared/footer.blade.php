{{--
<footer id="footer" class="container-xl">
    <div class="row">
        <div class="col-md-3">
            {!!  Mediaclass::on(Cached::footer())->fetch()->serve()->render() !!}
            <p>{{ Cached::footer()->abstract }}</p>
        </div>

        <div class="col-md-3">
            <h5 class="h5 footer-title">Navigation</h5>
            {!! (new \App\Printers\Nav\Footer('footer_1'))() !!}
        </div>

        <div class="col-md-3">
            <h5 class="h5 footer-title">Informations</h5>
            {!! (new \App\Printers\Nav\Footer('footer_2'))() !!}
        </div>

        <div class="col-md-3">
            <h5>Contact</h5>
            <div class="address">
                <p>{!! nl2br(Cached::contacts()['address'] ?? '')  !!}</p>
                <p>{{ Cached::contacts()['phone'] }}</p>
            </div>
            <div class="socials">
                <nav>
                    @foreach(Cached::socials() as $key => $item)
                        <a class="nav-link" href="{{ $item }}">
                            <i class="icon-{{ $key }}"></i>
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        {!! (new \App\Printers\Nav\Links('footer_3'))() !!}
        <a class="footer-bottom-container-links-item">Copyright {{ date('Y') }}</a>

    </div>
</footer>
--}}
