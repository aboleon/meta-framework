<div class="form-check {{ $class }}">
    <input class="form-check-input" type="checkbox" name="{{ $name }}" value="{{$value}}" id="{{ $name }}" {{ $isSelected() ? ' checked' : '' }}/>
    @if ($label)
        <label class="form-check-label" for="{{ $name }}">
            {!! $label !!}
        </label>
    @endif
</div>
