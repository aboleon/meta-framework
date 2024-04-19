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
@if($readonly)
    readonly
@endif
>{!! $value !!}</textarea>

<x-mfw::validation-error :field="$validation_id"/>

@if(str_contains($class,'simplified') or str_contains($class, 'extended'))
    @include('mfw::lib.tinymce')
@endif
