<x-backend-layout>
    <x-slot name="header">
        <h2>
            Configuration
        </h2>
    </x-slot>

    @php
        $error = $errors->any();
    @endphp

    <x-aboleon-framework::response-messages/>
    <form method="post" action="{{ route('aboleon-framework.settings.update') }}">
        @csrf
        <div class="row editable">
            @foreach($config_settings as $config_setting)
                <div class="col-md-12">
                    <div class="bloc-editable">
                        <h4>{{ $config_setting['title'] }}</h4>
                        @foreach($config_setting['elements'] as $item)
                            @php
                                $value = $error
                                ? old($item['name'])
                                : (App\Models\Setting::value($item['name']) ?: App\Models\Setting::defaultSettingValue($item['name']));
                            @endphp
                            @if($item['type'] == 'textarea')
                                <x-aboleon-inputable::textarea name="{{ $item['name'] }}"
                                                               class="{{  $item['class'] ?? ''}}"
                                                               :label="$item['title'] ?? ''"
                                                               :value="$value"/>
                            @else
                                @php
                                    try {
                                @endphp
                                <x-aboleon-inputable::input name="{{  $item['name'] }}"
                                                            type="{{ $item['type'] }}"
                                                            label="{!! $item['title'] ?? '' !!}"
                                                            class="{{ $item['class'] ?? '' }}"
                                                            value="{!! $value  !!}"/>

                                @php
                                    } catch(Throwable $e) {
                                    d($value);
                                //    d($item);
                                    }
                                @endphp
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <x-aboleon-framework::btn-save/>
    </form>
</x-backend-layout>
