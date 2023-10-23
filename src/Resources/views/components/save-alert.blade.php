@props(['container'=> '#main'])
@pushonce('js')
    <div id="mfw-intended-click" data-change="0"></div>
    <div class="modal fade" tabindex="-1" id="mfw-unsaved-content-modal">
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
                    <button type="button" id="mfw-intented-click-confirm" class="btn btn-danger">Continuer sans sauvgarger</button>
                </div>
            </div>
        </div>
    </div>
    <script>
      setTimeout(function () {

        const mwf_calculateChecksum = () => {
          return $('{{ $container }}').html();
        };

        const mfw_intented_click = $('#mfw-intended-click'),
          mfwUnsavedContenModal = new bootstrap.Modal(document.getElementById('mfw-unsaved-content-modal')),
          initialChecksum = mwf_calculateChecksum();

        $('{{ $container }}').find('input, textarea, select').change(function () {
          mfw_intented_click.attr('data-change', 1);
        });

        $('a').off().click(function (e) {

          const href = $(this).attr('href');

          if (href === undefined) {
            return true;
          }

          if (href.startsWith('http://') || href.startsWith('https://')) {

            let newCheksum = mwf_calculateChecksum();
            console.log(newCheksum.length, initialChecksum.length);
            if (newCheksum !== initialChecksum || mfw_intented_click.attr('data-change') == 1) {
              mfw_intented_click.text(href);
              e.preventDefault();
              mfwUnsavedContenModal.show();
              $('#mfw-intented-click-confirm').off().click(function () {
                window.location.assign(mfw_intented_click.text());
              });
            } else {
              return true;
            }
          } else {
            return true;
          }
        });
      }, 500);
    </script>

@endpushonce
