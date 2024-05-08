<div class="d-inline-block relative {{ $classes }}" id="instant-search" data-ajax="{{ route('aboleon-framework.ajax') }}">
    <input type="search" class="form-control" data-type="{{ $scope }}" placeholder="Recherche rapide"/>
</div>
@push('js')
    <script src="{!! asset('vendor/aboleon/framework/js/components/instant_search.js') !!}"></script>
@endpush
