<li class="{{ $className }}">
    <a target="{{ $target ?? '_self' }}" href="{{ $route }}" class="{{ request()->routeIs($route) ? 'active ':'' }}">
        @if ($icon)
            <i class="{{ $icon }}"></i>
        @endif
        {{ $title }}
    </a>
</li>
