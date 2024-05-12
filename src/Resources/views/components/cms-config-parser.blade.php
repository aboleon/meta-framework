@foreach($config as $key => $subconfig)
    <div class="{{ $subconfig['class'] ?? 'col-12' }} mb-4">
        @switch($subconfig['type'] ?? '')
            @case('textarea')
                <x-aboleon-inputable::textarea :name="$key"
                                               class="{{ $subconfig['class'] ?? '' }}"
                                               :value="$model->{$key}"
                                               :label="$subconfig['label'] ?? ''"/>
                @break
            @case('number')
                <x-aboleon-inputable::input type="number"
                                            :name="$key"
                                            :value="$model->{$key}"
                                            :label="$subconfig['label'] ?? ''"
                                            :params="$subconfig['params'] ?? []"/>
                @break
            @case('media')
                <x-mediaclass::uploadable :model="$model" :settings="array_merge($subconfig, ['subgroup' => $uuid])"/>
                @break;
            @case('clonable')
                <x-aboleon-framework::clonable :label="$subconfig['label'] ?? ''" :clonable="new $subconfig['model']" :items="$model->{$key}" :requestkey="$key" />
                @break
            @default
                <x-aboleon-inputable::input :name="$key"
                                            :value="$model->{$key}"
                                            :label="$subconfig['label'] ?? ''"
                                            :params="$subconfig['params'] ?? []"/>
        @endswitch
    </div>
@endforeach
