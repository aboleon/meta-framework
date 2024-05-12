@props([
    'saveexit' => false
])
<button form="aboleon-framework-form" class="btn btn-sm btn-warning mx-2">
    <i class="fa-solid fa-check"></i>
    {{ __('aboleon-framework.save') }}
</button>
@if ($saveexit)
    <button form="aboleon-framework-form" class="btn btn-sm btn-info mx-2" id="aboleon-framework-save-redirect-btn">
        <i class="fa-solid fa-check"></i>
        {{ __('aboleon-framework.save_quit') }}
    </button>
    @push('js')
        <script>
            $('#aboleon-framework-save-redirect-btn').click(function (e) {
                e.preventDefault();
                $('#aboleon-framework-form').append('<input type="hidden" name="save_and_redirect"/>');
                $('#aboleon-framework-form').submit();
            });
        </script>
    @endpush
@endif
