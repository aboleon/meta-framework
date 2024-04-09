<div class="{{ rtrim('form-check' . ($switch ? ' form-switch' : '') .' '. $class) }}">
    <input class="form-check-input" type="checkbox"{!! $switch ? ' role="switch"' :'' !!} name="{{ $name }}" value="{{ $value }}" id="{{ $id }}"{{ $isSelected ? ' checked' : '' }}
    @forelse($params as $param => $setting)
        {{ $param }}="{!! $setting !!}"
    @empty
    @endforelse
    />
    @if ($label)
        <label class="form-check-label" for="{{ $id }}">
            {{ $label }}
        </label>
    @endif
</div>
