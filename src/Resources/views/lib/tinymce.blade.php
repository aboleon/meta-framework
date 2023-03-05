@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.8.2/tinymce.min.js"></script>
    <script id="tinymce_settings" src="{!! asset('vendor/metaframework/js/tinymce/default_settings.js') !!}"></script>
    <script>
        tinymce.init(settings);
        $(function() {
            if ($('textarea.simplified').length) {
                var url = "{!! asset('vendor/metaframework/js/tinymce/simplified.js') !!}";
                $.when($.getScript(url)).then(function() {
                    tinymce.init(intro_settings);
                });
            }
        });
    </script>
@endpush
