@if ($fillables)
    @foreach($fillables as $key=>$value)
        @php
            $array_key = $datakey ? $datakey.'['.$key.']' : $key;
        @endphp

        @switch($value['type'] ?? '')
            @case('textarea')
            @case('textarea_extended')
                <div class="{{ $value['class'] ?? 'col-12' }} mb-4">
                    <x-mfw::textarea name="{{$array_key}}[{{$locale}}]"
                                     :value="$model->translation($key, $locale)"
                                     :label="$value['label']"/>
                </div>
                @break
            @default

                <div class="{{ $value['class'] ?? 'col-12' }} mb-4">
                    <x-mfw::input name="{{$array_key}}[{{$locale}}]"
                                  :value="$model->translation($key, $locale)"
                                  :label="$value['label']"/>
                </div>
        @endswitch
    @endforeach
@endif