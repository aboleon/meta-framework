@if (isset($object) && $object instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $object->withQueryString()->links() }}
@endif
