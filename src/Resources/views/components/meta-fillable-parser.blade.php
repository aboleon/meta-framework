<div class="{{ $value['class'] ?? 'col-12' }} mb-4{{ $model->visibility($key) }}">

    @switch($key)
        @case('_media')
            <x-mediaclass::uploadable :model="$model->meta ?? \MetaFramework\Accessors\Metas::fetchSingleByType($model::$signature)" :settings="$value"/>
            @break;
        @default
            @switch($value['type'] ?? '')
                @case('textarea')
                    <x-metaframework::textarea :name="$model->translatableInput($inputkey)" class="{{ $value['class'] ?? '' }}" :value="$content" :label="$value['label'] ?? ''"/>
                    @break
                @case('component')
                    @if (auth()->user()->hasRole('dev'))
                        <code class="d-block pb-2">
                            {!! 'metaframework.backend.'.$model->type.'.component_'.$subkey !!}
                            {{ !view()->exists('metaframework.backend.'.$model->type.'.component_'.$subkey) ? ' - A créer' : '' }}
                        </code>
                    @endif
                    @includeIf('panel.'.$model->type.'.component_'.$subkey)
                    @break
                @case('number')
                    <x-metaframework::input type="number" :name="$model->translatableInput($inputkey)" :value="$content" :label="$value['label'] ?? ''" :params="$value['params'] ?? []"/>
                    @break
                @case('_media')
                    <x-mediaclass::uploadable :model="$model->meta ?? \MetaFramework\Accessors\Metas::fetchSingleByType($model::$signature)" :settings="$value"/>
                    @break;
                @case('repeatable')

                    @for($i=0;$i<$value['count'];++$i)
                        <div class="row">
                            <div class="col-md-1 col-sm-2 repeatable pe-0">
                                <div>
                                    <span class="i-counter">{{$i+1}}</span>
                                </div>
                            </div>
                            <div class="col-md-11 col-sm-10">
                                <div class="row">
                                    @foreach($value['schema'] as $rep_key => $rep_val)
                                        <x-metaframework::meta-fillable-parser
                                            :model="$model"
                                            :key="$key"
                                            :subkey="$rep_key"
                                            :value="$rep_val"
                                            :content="is_string($content) ? $content : $content[$rep_key][$i]"
                                            :inputkey="$inputkey.'['.$rep_key.']['.$i.']'"/>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endfor
                    @break
                @default
                    <x-metaframework::input :name="$model->translatableInput($inputkey)" :value="$content" :label="$value['label'] ?? ''" :params="$value['params'] ?? []"/>
            @endswitch
    @endswitch
</div>
