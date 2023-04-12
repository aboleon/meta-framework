<div class="{{ rtrim('form-check' . ($switch ? ' form-switch' : '') .' '. $class) }}">
    <input class="form-check-input" type="checkbox"{!! $switch ? ' role="switch"' :'' !!} name="{{ $name }}" value="{{ $value }}" id="{{ $forLabel }}"{{ $isSelected ? ' checked' : '' }}/>
    @if ($label)
        <label class="form-check-label" for="{{ $forLabel }}">
            {{ $label }}
        </label>
    @endif
</div>
