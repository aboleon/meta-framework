@if ($label)
    <label for="{{ $id }}" class="form-label">{!! $label !!}</label>
@endif

<select id="{{ $id }}"
        @if (!$disablename)
            name="{{ $name }}"
        @endif
        class="{{ $class }}" title="{{ $label ?: $name }}"
@forelse($params as $param => $setting)
    {{ $param }}="{!! $setting !!}"
@empty
@endforelse
>
    @if ($nullable)
        <option value="">{{ $defaultselecttext }}</option>
    @endif

    @if ($group)
        @foreach($values as $optgroup_id => $optgroup)
            <optgroup data-id="{{ $optgroup_id }}" label="{{ $optgroup['name'] }}">
                @foreach($optgroup['values'] as $key => $value)
                    <option value="{{ $key }}"{{ $affected && $key == $affected ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
            </optgroup>

        @endforeach
    @else
        @foreach($values as $key => $value)
            <option value="{{ $key }}"{{ $affected && $key == $affected ? 'selected' : '' }}>{{ $value }}</option>
        @endforeach

    @endif
</select>
<x-mfw::validation-error :field="$validation_id"/>
