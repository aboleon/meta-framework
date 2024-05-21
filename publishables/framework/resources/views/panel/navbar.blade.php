<nav class="nav navbar navbar-expand-lg text-dark navbar-nav p-0">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                   aria-expanded="false">
                    <img src="{!! \Aboleon\MetaFramework\Services\Avatars\Avatar::avatar(auth()->user()) !!}"
                         alt="{{ auth()->user()->names() }}" width="36" height="36"/>
                </a>
                <ul class="dropdown-menu" style="left:initial;right: 0">
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="ps-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a href="{{ route('logout') }}"
                               class="text-decoration-none text-danger"
                               onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </a>
                        </form>

                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
