<x-mfw::input :value="$value" :label="$label" :class="$class" :required="$required" :params="$params" />
@once
    @include('mfw::lib.flatpickr')
@endonce