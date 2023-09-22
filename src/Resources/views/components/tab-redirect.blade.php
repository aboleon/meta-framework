<input type="hidden" name="mfw_tab_redirect" id="mfw-tab-redirect"/>
@push('js')
    <script>

        @if(session('mfw_tab_redirect'))
            $('#{{ session('mfw_tab_redirect') }}').trigger('click');
        @endif

        $('.mfw-tab').on('shown.bs.tab', function (e) {
          $('#mfw-tab-redirect').val($(e.target).attr('id'));
        });
    </script>
@endpush