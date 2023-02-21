<a class="header opening ps-{{ $icon ? '0 with-icon'  : 4 }} {{ $class }}">
    @isset($icon)
        <i class="icon {{ $icon }}"></i>
    @endif
    {{ $title }}
    <i class="fas fa-chevron-down"></i>
</a>
