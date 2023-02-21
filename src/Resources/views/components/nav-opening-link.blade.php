<a href="#">
    @isset($icon)
        <i class="{{ $icon }}"></i>
    @endif
    <span class="menu-text">{{ $title }}</span>
    <i class="fas fa-chevron-down float-end"></i>
</a>
