<input type="hidden" name="aboleon-framework_tab_redirect" id="aboleon-framework-tab-redirect"/>
@push('js')
    <script>

        @if(session('aboleon-framework_tab_redirect'))
            $('#{{ session('aboleon-framework_tab_redirect') }}').trigger('click');
        @endif

        $('{{ $selector }}').on('shown.bs.tab', function (e) {
          $('#aboleon-framework-tab-redirect').val($(e.target).attr('id'));
        });
    </script>
@endpush