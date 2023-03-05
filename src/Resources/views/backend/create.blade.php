<x-backend-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Créer une page
        </h2>
    </x-slot>

    @push('css')
        {!! csscrush_tag(public_path('vendor/metaframework/css/meta/editable.css')) !!}
    @endpush

    <form method="post" action="{{ route(config('metaframework.urls.backend').'.meta.store') }}">
        @csrf
        <input type="hidden" name="meta_type" value="{{ $data->type }}">
        <x-metaframework::meta-card :meta="$data"/>
        <x-metaframework::btn-save/>
    </form>
</x-backend-layout>
