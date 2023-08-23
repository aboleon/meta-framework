<x-mfw::input :name="$name" :value="$value" :label="$label" :class="$className" :required="$required" :params="$params" />
@pushonce('js')
<script src="{{ asset('vendor/mfw/components/inputdatemask.js') }}"></script>
@endpushonce