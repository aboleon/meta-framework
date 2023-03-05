<div class="d-inline-block relative {{ $classes }}" id="instant-search" data-ajax="{{ route('metaframework.ajax') }}">
    <input type="search" class="form-control" data-type="{{ $scope }}" placeholder="Recherche rapide"/>
</div>
@push('js')
    <script src="{!! asset('vendor/metaframework/js/components/instant_search.js') !!}"></script>
@endpush
