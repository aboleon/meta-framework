<div class="{{  $class }}">
    <x-mfw::input :name="$name" class="iban" :value="$value" :label="$label"/>
    <div class="feedback invalid-feedback d-none">IBAN invalide</div>
    <div class="feedback valid-feedback d-none">IBAN valide</div>
</div>
@pushonce('js')
    <script src="{{ asset('vendor/mfw/components/iban-validator.js') }}"></script>
    <script>
      $(function () {
        $('.iban').on('keyup change', function () {
          let c = $(this).closest('.iban-validator'), input = $(this);
          $(this).removeClass('is-valid is-invalid');
          c.find('feedback').addClass('d-none');
          setDelay(function () {
            if (input.val().length) {
              if (isValidIBANNumber(input.val())) {
                c.find('.valid-feedback').removeClass('d-none');
                input.addClass('is-valid');
              } else {
                c.find('.invalid-feedback').removeClass('d-none');
                input.addClass('is-invalid');
              }
            }
          }, 500);
        });
      });
    </script>
@endpushonce
