@push('css')
<link rel="stylesheet" href="{!! asset('Mediaclass/jQuery-File-Upload/css/jquery.fileupload.css') !!}"/>
<link rel="stylesheet" href="{!! asset('Mediaclass/jQuery-File-Upload/css/jquery.fileupload-ui.css') !!}"/>
{!! csscrush_tag(public_path('Mediaclass/css/styles.css')) !!}
@endpush

@push('js')
<script src="{!! asset('Mediaclass/jQuery-File-Upload/js/vendor/jquery.ui.widget.js') !!}"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="{!! asset('Mediaclass/jQuery-File-Upload/js/tmpl.min.js') !!}"></script>
<script src="{!! asset('Mediaclass/jQuery-File-Upload/js/load-image.all.min.js') !!}"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="{!! asset('Mediaclass/jQuery-File-Upload/js/jquery.iframe-transport.js') !!}"></script>
<!-- The basic File Upload plugin -->
<script src="{!! asset('Mediaclass/jQuery-File-Upload/js/jquery.fileupload.js') !!}"></script>
<!-- The File Upload processing plugin -->
<script src="{!! asset('Mediaclass/jQuery-File-Upload/js/jquery.fileupload-process.js') !!}"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="{!! asset('Mediaclass/jQuery-File-Upload/js/jquery.fileupload-image.js') !!}"></script>
<!-- The File Upload validation plugin -->
<script src="{!! asset('Mediaclass/jQuery-File-Upload/js/jquery.fileupload-validate.js') !!}"></script>
<!-- The File Upload user interface plugin -->
<script src="{!! asset('Mediaclass/jQuery-File-Upload/js/jquery.fileupload-ui.js') !!}"></script>
<script src="{!! asset('Mediaclass/uploader.js') !!}"></script>
@endpush
