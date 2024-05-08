@php
    $config = collect(config('aboleon-framework-forms'))->where('name', $form->name)->first();
@endphp


@if (is_null($config))
    @if (config('app.debug'))
        Le formulaire {{ $form->name }} n'existe pas dans les configurations
    @endif
@else

    <form class="form-{{ $form->name }}" action="{{ route('form', $form->name) }}" method="post" id="form-{{ $form->name }}">
        @csrf
        <h3>{!! $label ?: __('aboleon-framework-forms.labels.'.$form->name) !!}</h3>

        <x-aboleon-framework::validation-errors/>
        <x-aboleon-framework::response-messages/>

        <div class="row">
            @foreach($config['fields'] as $field)
                <div class="col {{ $field['grid'] }} mb-3">
                    @php
                        $use_as_label = $field['label'] ?? $field['name'];
                        $label = array_key_exists($use_as_label, trans('forms')) ?  __('aboleon-framework-forms.'.$use_as_label) : $use_as_label;
                    @endphp
                    @switch($field['type'])
                        @case('textarea')
                            <x-aboleon-inputable::textarea :name="$field['name']" :label="$label" :value="old($field['name'])"/>
                            @break
                        @case('radio')
                            <x-aboleon-inputable::radio :name="$field['name']" :label="$label" :values="$field['values']" :affected="old($field['name'])"/>
                            @break
                        @case('btn-group')
                            <x-aboleon-framework::btn-group :name="$field['name']" :label="$label" :values="$field['values']" :affected="old($field['name']) ?: $field['default']"/>
                            @break
                        @case('checkbox')
                            <x-aboleon-inputable::checkbox :name="$field['name']" :label="$label" value="1" :affected="null"/>
                            @break
                        @case('select')
                            <x-aboleon-inputable::select :name="$field['name']" :label="$label" :values="$field['values']" :affected="null" />
                            @break
                        @default
                            <x-aboleon-inputable::input type="{{ $field['type'] }}" :name="$field['name']" :label="$label" :value="old($field['name'])" autocomplete="off"/>
                    @endswitch
                </div>
            @endforeach
            <div class="col text-center {{ $config['submit']['grid'] ?? 'col-12' }}">
                <button form="form-{{ $form->name }}" type="submit">{{ $btn ?: __('aboleon-framework-forms.save') }}</button>
            </div>
        </div>
    </form>
@endif
