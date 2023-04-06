<x-backend-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Configuration
        </h2>
    </x-slot>

    @push('css')
        {!! csscrush_tag(public_path('css/show.css')) !!}
    @endpush
    <x-mfw::validation-errors/>
    <x-mfw::response-messages/>
    <form method="post" action="{{ route('mfw.settings.update') }}">
        @csrf
        <div class="row editable">
            @foreach($config_settings as $config_setting)
                <div class="col-md-12">
                    <div class="bloc-editable">
                        <h2>{{ $config_setting['title'] }}</h2>
                        @foreach($config_setting['elements'] as $input)
                            @if($input['type'] == 'textarea')
                                <x-mfw::textarea :name="$input['name']"
                                                           class="{{$input['class'] ?? ''}}"
                                                           :label="$input['title'] ?? ''"
                                                           :value="old($input['name']) ?: MetaFramework\Models\Setting::get($input['name']) ?: ''"/>
                                @once
                                    @include('mfw::lib.tinymce')
                                @endonce
                            @else
                                <x-mfw::input name="{{$input['name']}}"
                                                        type="{{ $input['type'] }}"
                                                        label="{!! $input['title'] ?? '' !!}"
                                                        className="{{ $input['class'] ?? '' }}"
                                                        value="{!! old($input['name']) ?: MetaFramework\Models\Setting::get($input['name']) ?: '' !!}"/>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <x-mfw::btn-save/>
    </form>
</x-backend-layout>
