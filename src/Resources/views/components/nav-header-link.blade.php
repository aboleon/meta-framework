<li class="{{ $class }}">
    <a target="{{ $target ?? '_self' }}"
       href="{{ $route }}"
       class="{{ $class }} header ps-{{ ($icon ? '0 with-icon'  : 4) .(request()->routeIs($route) ? ' active ':'') }}">
        @if ($icon)
            <i class="icon {{ $icon }}"></i>
        @endif
        {{ $title }}
    </a>
</li>
