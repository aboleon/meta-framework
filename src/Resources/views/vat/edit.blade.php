<x-backend-layout>

    <x-slot name="header">
        <h2>
            {{ $data->id ? __('mfw-sellable.vat.label'). " #" . $data->id : __('mfw-sellable.vat.new') }}
        </h2>
        <div class="d-flex align-items-center" id="topbar-actions">
            <a class="btn btn-sm btn-secondary mx-2"
               href="{{ route('mfw.vat.index') }}">
                <i class="fa-solid fa-bars"></i>
                Index
            </a>
            <a class="btn btn-sm btn-success"
               href="{{ route('mfw.vat.create') }}">
                <i class="fa-solid fa-circle-plus"></i>
                {{ __('mfw.create') }}
            </a>

            <div class="separator"></div>
            <x-mfw::save-btns/>
        </div>
    </x-slot>
    @php
        $error = $errors->any();
    @endphp

    <div class="max-w-7xl text-center mb-4">
        <a class="btn btn-sm btn-info"
           href="{{ route('mfw.vat.index') }}">Retour à l'index</a>
    </div>

    <div class="shadow p-3 mb-5 bg-body-tertiary rounded">
        <div class="row m-3">
            <div class="col">
                <x-mfw::response-messages/>
                <x-mfw::validation-errors/>

                @php
                    $error = $errors->any();
                @endphp

                <form method="post" action="{{ $route }}" id="mfw-form">


                    @csrf
                    @if($data->id)
                        @method('put')
                    @endif


                    <div class="row mb-4">
                        <div class="col-12">
                            <h4 class="mt-3">TVA</h4>
                            <div class="row">
                                <div class="col-lg-6">
                                    <x-mfw::input name="vat[rate]" :value="$error ? old('vat.rate') : number_format($data->rate, 2, '.')" :label="__('mfw-sellable.vat.percent')"/>
                                </div>
                                <div class="col-lg-6">
                                    <x-mfw::radio :values="['Non','Oui']" :affected="$error ? old('vat.default') : $data->default" name="vat[default]" :label="__('mfw-sellable.vat.is_this_default')" :nullable="false"/>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="mt-5 main-save">
                        <x-mfw::btn-save/>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('vendor/mfw/js/published_status.js') }}"></script>
    @endpush
    @include('mfw::lib.tinymce')
</x-backend-layout>
