@php
    $id = rtrim(str_replace(['[',']'],'_', $name),'_');
@endphp
@if ($label)
    <label for="{{$id}}" class="form-label">
        {{ $label }}
    </label>
@endif
<textarea name="{{ $name }}"
          class="form-control {{ is_array($class) ? explode(' ', $class) : $class }}"
          id="{{ $id }}"
          {!! !empty($height) ? 'style="height:'.$height.'px"' : '' !!}
@forelse($params as $param => $setting)
    {{ $param }}="{!! $setting !!}"
@empty
@endforelse
          @if($required)
              required
@endif>{!! $value !!}</textarea>
