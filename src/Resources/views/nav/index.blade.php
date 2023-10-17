<x-backend-layout>

    @push('css')
        <style>
            td.phone span {
                display: block;
            }

            table caption {
                caption-side: top;
            }
        </style>
    @endpush

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Menu principal &raquo;
            <a class="btn btn-sm btn-success"
               href="{{ route('mfw.nav.create') }}">Créer une entrée principale</a>

        </h2>
    </x-slot>

    <div class="shadow p-4 bg-body-tertiary rounded">

        <div id="messages" data-ajax="{{ route('mfw.ajax') }}">
            <x-mfw::response-messages/>
        </div>

        @foreach($zones as $key => $title)
            <div class="bg-white shadow-xl sm:rounded-lg p-4 mb-5">
                <table class="table table-hover">
                    <caption>{{ $title }}</caption>
                    <thead style="border-bottom: 2px solid #a7c0cc;">
                    <tr>
                        <th>Intitulé</th>
                        <th>Type</th>
                        <th>URL</th>
                        <th style="width: 200px">Actions</th>
                    </tr>
                    </thead>
                    <tbody id="zone_{{ $key }}">
                    {!! ${$key} !!}
                    </tbody>
                </table>
            </div>
            @push('js')
                <script>
                  $(function () {
                    sortableContent($('#zone_{{$key}}'), 'tr', $('#messages'), 'nav');
                  });</script>
            @endpush
        @endforeach
    </div>

    @include('mfw::lib.sortable')
</x-backend-layout>
