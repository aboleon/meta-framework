@pushonce('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.8.2/tinymce.min.js" defer></script>
    <script>
      $(function () {
        if ($('textarea.extended').length) {
          $.when($.getScript("{!! asset('vendor/mfw/js/tinymce/default_settings.js') !!}")).then(function () {
            tinymce.init(mfw_default_tinymce_settings('textarea.extended'));
          });
        }
        if ($('textarea.simplified').length) {
          $.when($.getScript("{!! asset('vendor/mfw/js/tinymce/simplified.js') !!}")).then(function () {
            tinymce.init(mfw_simplified_tinymce_settings('textarea.simplified'));
          });
        }
      });
    </script>
@endpushonce
