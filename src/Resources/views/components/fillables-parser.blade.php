@php
    $error = $errors->any();
@endphp
@if ($fillables)
    @foreach($fillables as $key=>$value)
        @php
            $array_key = $datakey ? $datakey.'['.$key.']' : $key;
            $params = $disabled ? ['disabled' => true] : [];
        @endphp

        @switch($value['type'] ?? '')
            @case('textarea')
                <div class="{{ $value['class'] ?? 'col-12' }} mb-4">
                    <x-aboleon-inputable::textarea name="{{$array_key}}[{{$locale}}]"
                                                   :value="$error ? old(str_replace(['[', ']'], ['.', ''], $array_key).'.'.$locale) : $model->translation($key, $locale)"
                                                   :label="$value['label'] ?? ''"
                                                   :class="$value['class'] ?? ''"
                                                   :required="in_array('required',$value)"
                                                   :params="$params"/>
                </div>
                @break
            @default

                <div class="{{ $value['class'] ?? 'col-12' }} mb-4">
                    <x-aboleon-inputable::input name="{{$array_key}}[{{$locale}}]"
                                                :value="$error ? old(str_replace(['[', ']'], ['.', ''], $array_key).'.'.$locale) : $model->translation($key, $locale)"
                                                :label="$value['label'] ?? ''"
                                                :required="in_array('required',$value)"
                                                :params="$params"/>
                </div>
        @endswitch
    @endforeach
@else
    @if ($parsed)
        <x-aboleon-framework::alert
                message="A parse was attempted on {!! implode(', ',array_map(fn($item) => '<em>\''.$item.'\'</em>', $parsed), ) !!}"
                type="warning"/>
    @endif
@endif
