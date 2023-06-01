@if ($label)
    <label for="{{$id}}" class="form-label">
        {{ $label  . ($required ? ' *' : '') }}
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
@endif
>{!! $value !!}</textarea>
<x-mfw::validation-error :field="$validation_id"/>
