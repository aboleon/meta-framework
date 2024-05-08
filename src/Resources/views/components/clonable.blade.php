<div class="fillable bloc-editable bloc-clonable" data-repeatable="{{ $repeatable }}">
    <h2>{{ $label }}</h2>

    @foreach($items as $model)

        <div class="row clonable py-4 aboleon-framework-line-separator" data-id="{{  $identifier }}">

            <div class="col-md-1 col-sm-2 repeatable pe-0">
                <div>
                    <span class="i-counter">{{ $loop->iteration }}</span>
                    <i class="fa-solid fa-circle-xmark i-remove not-draggable"></i>
                </div>
            </div>

            <div class="col-md-11 col-sm-10 not-draggable">
                <div class="row">
                    @foreach($schema as $key => $config)
                        @php
                            $content_value = $model?->{$key};
                        @endphp
                        <div class="cloned-{{ $key .' '. ($config['class'] ?? 'col-12') }} mb-3">
                            @switch($config['type'] ?? '')
                                @case('textarea')
                                    <x-aboleon-inputable::textarea :name="$key.'.'"
                                                                   class="{{ $config['input_class'] ?? '' }}"
                                                                   :value="$content_value"
                                                                   :label="$config['label'] ?? ''"
                                                                   :randomize="true"/>
                                    @break
                                @case('number')
                                    <x-aboleon-inputable::input type="number"
                                                                :name="$key.'.'"
                                                                :value="$content_value"
                                                                :label="$config['label'] ?? ''"
                                                                :params="$config['params'] ?? []"
                                                                :randomize="true"/>
                                    @break
                                @case('media')
                                    <x-mediaclass::uploadable :model="$model"
                                                              :settings="array_merge($config, ['subgroup' => $identifier])"
                                                              :randomize="true"/>
                                    @break;
                                @default
                                    <x-aboleon-inputable::input :name="$key.'.'"
                                                                :value="$content_value"
                                                                :label="$config['label'] ?? ''"
                                                                :params="$config['params'] ?? []"
                                                                :randomize="true"/>
                            @endswitch
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    @endforeach

    @if ($clonable)
        <span class="cloner btn btn-default btn-sm not-draggable">Ajouter un élément</span>
    @endif
</div>

@pushonce('js')
    <script src="{{ asset('vendor/aboleon/framework/components/clonable.js') }}"></script>
@endpushonce
