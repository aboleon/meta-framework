@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/jquery-ui-1.13.0.custom/jquery-ui.min.css') }}">
@endpush
@push('js')
    <script src="{{ asset('vendor/jquery-ui-1.13.0.custom/jquery-ui.min.js') }}"></script>
    <script>
        $(function () {
            $('.sortables').each(function () {
                let c = $(this);
                $(this).sortable({
                    stop: function (event, ui) {
                        let data = [];
                        c.find('.sortable').each(function (index) {
                            $(this).attr('data-index', index);
                            data.push({
                                'index': index,
                                'id': $(this).data('id'),
                            });
                        });
                        ajax('action=sortable&target='+c.data('target')+
                            '&'+$.param({'data':data}), c);
                    },
                });
            });
        });
    </script>
@endpush
