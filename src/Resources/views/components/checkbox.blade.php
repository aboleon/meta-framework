<div class="form-check {{ $class }}">
    <input class="form-check-input" type="checkbox" name="{{ $name }}" value="{{ $value }}" id="{{ $forLabel }}" {{ $isSelected ? ' checked' : '' }}/>
    @if ($label)
        <label class="form-check-label" for="{{ $forLabel }}">
            {{ $label }}
        </label>
    @endif
</div>
