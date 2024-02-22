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
    @pushonce('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.8.2/tinymce.min.js"></script>
        <script id="tinymce_settings" src="{!! asset('vendor/mfw/js/tinymce/default_settings.js') !!}"></script>
        <script>
          if ($('textarea.extended').length) {
            tinymce.init(mfw_default_tinymce_settings('textarea.extended'));
          }
          $(function() {
            if ($('textarea.simplified').length) {
              var url = "{!! asset('vendor/mfw/js/tinymce/simplified.js') !!}";
              $.when($.getScript(url)).then(function() {
                tinymce.init(mfw_simplified_tinymce_settings('textarea.simplified'));
              });
            }
          });
        </script>
    @endpushonce
@endif
