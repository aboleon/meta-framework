@props(['container'=> '#main'])
@pushonce('js')
    <div id="aboleon-framework-intended-click" data-change="0"></div>
    <div class="modal fade" tabindex="-1" id="aboleon-framework-unsaved-content-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alerte contenu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-dark">Il semble que vous avez du contenu non-sauvegardé. Si vous continuez, vous allez perdre les changements apportés.</p>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Revenir</button>
                    <button type="button" id="aboleon-framework-intented-click-confirm" class="btn btn-danger">Continuer sans sauvegarder</button>
                </div>
            </div>
        </div>
    </div>
    <script>
      setTimeout(function () {

        const mwf_calculateChecksum = () => {
          return $('{{ $container }}').html();
        };

        const aboleon-framework_intented_click = $('#aboleon-framework-intended-click'),
          aboleon-frameworkUnsavedContenModal = new bootstrap.Modal(document.getElementById('aboleon-framework-unsaved-content-modal')),
          initialChecksum = mwf_calculateChecksum();

        $('{{ $container }}').find('input, textarea, select').change(function () {
          aboleon-framework_intented_click.attr('data-change', 1);
        });

        $('a').click(function (e) {

          const href = $(this).attr('href');

          if (href === undefined) {
            return true;
          }

          if (href.startsWith('http://') || href.startsWith('https://')) {

            let newCheksum = mwf_calculateChecksum();
            console.log(newCheksum.length, initialChecksum.length);
            if (newCheksum !== initialChecksum || aboleon-framework_intented_click.attr('data-change') == 1) {
              aboleon-framework_intented_click.text(href);
              e.preventDefault();
              aboleon-frameworkUnsavedContenModal.show();
              $('#aboleon-framework-intented-click-confirm').off().click(function () {
                window.location.assign(aboleon-framework_intented_click.text());
              });
            } else {
              return true;
            }
          } else {
            return true;
          }
        });
      }, 1000);
    </script>

@endpushonce
