@php
    $id = rtrim(str_replace(['[',']'],'_', $name),'_');
    $field_name = str_replace(['[', ']'], ['.', ''], $name);
@endphp
@if ($label)
    <label for="{{ $id }}" class="form-label">{{ $label . ($required ? ' *' : '') }}</label>
@endif
<input type="{{ $type ?? 'text' }}"
       name="{{ $name }}"
       class="form-control {{ $class ?? ''  }}"
       id="{{ $id }}"
       value="{{ $value }}"
@forelse($params as $param => $setting)
    {{ $param }}="{!! $setting !!}"
@empty
@endforelse
@if($required)
    required
@endif
>
@error($field_name)
    <div class="invalid-feedback d-block">{{ $message }}</div>
@enderror
