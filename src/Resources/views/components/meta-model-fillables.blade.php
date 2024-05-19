@php
    $model = $meta->subModel();
    $content = $model;
    if ($model->isReliyingOnMeta()) {
        $content = $model->isStoringMetaContentAsJson() ? json_decode($meta->content,true) : $meta;
    }
    $model->getFillables();
@endphp

@if ($model->fillables)
    @foreach($model->fillables as $key => $collection)
        @php
            $repeatable = (int)$collection['repeatable'] ??=1;
            $iterable = $repeatable;

            $clonable = $collection['clonable'] ?? false;
            $schema = isset($collection['schema']);
            $key_content = (is_array($content) && array_key_exists($key, $content))
                ? ($content[$key] ?? null)
                : ($content->{$key} ?? null);

            if ($clonable) {
                $iterable = is_countable($key_content) ? count($key_content) : 1;
            }
        @endphp

        <div class="fillable bloc-editable{{ $clonable ? ' bloc-clonable' :'' }}" data-repeatable="{{ $repeatable }}">
            @if ($schema)
                <h2>{{ $collection['label'] }}</h2>
            @endif
            @for($i=0;$i<$iterable;++$i)
                @php
                    $uuid = \Illuminate\Support\Str::random(8);
                    $found_content = $content;
                    $grouped = str_starts_with($key, '_group');
                    $is_meta = str_starts_with($key,'meta[');

                    if ($is_meta) {
                        $key = str_replace(['meta[',']'],'', $key);
                        $found_content = $content->{$key};
                    }

                    if($schema && is_array($key_content)) {
                        $uuid = key($key_content);
                        $found_content = is_array(current($key_content)) ? array_shift($key_content) : $key_content;
                    }
                    $content_value = ($key != 'media')
                        ? (Aboleon\MetaFramework\Accessors\Locale::multilang()
                            ? $content->translation($key, $locale)
                            : ($content[$key] ?? null))
                        : null;
                    $input_key = $is_meta
                        ? $key
                        : ($model->getSignature(). (
                            $grouped
                                ? ''
                                : ('['.$key.']' . (
                                    ($repeatable > 1 or $clonable)
                                        ? '['.$uuid.']'
                                        : ''
                                    )
                                )
                            )
                        );
                @endphp

                <div class="row{{ $clonable ? ' clonable' : '' }}"{!! $clonable ? ' data-id="'.$uuid.'"' : '' !!}>
                    @if($iterable > 1 or $clonable)
                        <div class="col-md-1 col-sm-2 repeatable pe-0">
                            <div>
                                <span class="i-counter">{{$i+1}}</span>
                                @if ($clonable)
                                    <i class="fa-solid fa-circle-xmark i-remove not-draggable"></i>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-11 col-sm-10 not-draggable">
                            <div class="row">
                                @endif
                                @if ($schema)
                                    @foreach($collection['schema'] as $subkey => $value)
                                        @php
                                            $content_value = \Aboleon\MetaFramework\Accessors\Locale::multilang()
                                                ? ($found_content[$subkey][$locale] ?? '')
                                                : ($found_content[$subkey] ?? '');
                                        @endphp
                                        <x-aboleon-framework::meta-fillable-parser
                                                :model="$model"
                                                :key="$key"
                                                :subkey="$subkey"
                                                :value="$value"
                                                :content="$content_value"
                                                :inputkey="$input_key.'['.$subkey.']'"
                                                :uuid="$uuid"/>

                                    @endforeach
                                @else
                                    <x-aboleon-framework::meta-fillable-parser
                                            :model="$model"
                                            :subkey="$key"
                                            :key="$key"
                                            :content="$content_value"
                                            :value="$collection"
                                            :inputkey="$input_key"
                                            :uuid="null"/>
                                @endif
                                @if($iterable > 1 or $clonable)
                            </div>
                        </div>
                    @endif
                </div>
            @endfor

            @if ($clonable)
                <span class="cloner btn btn-default btn-sm not-draggable">Ajouter un élément</span>
            @endif
        </div>
    @endforeach
@endif
@once
    @push('js')
        <link rel="stylesheet" href="{{ asset('vendor/jquery-ui-1.13.0.custom/jquery-ui.min.css') }}">
        <script src="{{ asset('vendor/jquery-ui-1.13.0.custom/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('vendor/aboleon/framework/components/meta-model-fillables/clonable.js') }}"></script>
    @endpush
@endonce
