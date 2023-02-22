@php
    $id = rtrim(str_replace(['[',']'],'_', $name),'_');
@endphp
@if ($label)
    <label for="{{ $id }}" class="form-label">{!! $label !!}</label>
@endif

<select id="{{ $id }}"
        @if (!$disablename)
            name="{{ $name }}"
        @endif
        class="form-control" title="{{ $label ?: $name }}">
    @if ($nullable)
        <option value="">{{ $defaultselecttext }}</option>
    @endif

    @if ($group)
        @foreach($values as $optgroup)
            <optgroup label="{{ $optgroup['name'] }}">
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
