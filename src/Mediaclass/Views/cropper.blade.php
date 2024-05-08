<link href="{!! asset('vendor/aboleon/mediaclass/jcrop/jquery.Jcrop.css') !!}" rel="stylesheet">
<script src="{!! asset('vendor/aboleon/mediaclass/jcrop/jquery.Jcrop.js') !!}"></script>
<script src="{!! asset('vendor/aboleon/mediaclass/jcrop/jcrop.js') !!}"></script>
<script>
    function cropped(result) {
        if (!result.hasOwnProperty('error')) {
            MediaclassUploader.cropped(result);
        } else {
            $('#mediaclas-loader').addClass('d-none');
            $('#mediaclas-loader').removeClass('d-none');
        }
    }

    $(function () {
        $('#mediaclass-cropable-form').submit(function (e) {
            e.preventDefault();
            $('#mediaclass-crop-btn').addClass('d-none');
            $('#mediaclas-loader').removeClass('d-none');
            ajax('action=crop&' + $('#mediaclass-cropable-form input').serialize(), $('#mediaclass-cropable-form'));
        });
    });
</script>
<style>
    #mediaclass-cropable-form .form-control {
        padding: .375rem .75rem;
        border-radius: 6px !important;
    }
</style>
@php
    $url = $media->url(size:'xl');
    list($current_w, $current_h) = getimagesize($url);
@endphp

<form id="mediaclass-cropable-form" data-ajax="{{ route('mediaclass.ajax') }}">

    <input type="hidden" id="x1" name="x1image"/>
    <input type="hidden" id="y1" name="y1image"/>
    <input type="hidden" id="wi" name="wiimage" value="{!! $cropable->width() !!}"/>
    <input type="hidden" id="he" name="heimage" value="{!! $cropable->height() !!}"/>

    <input type=hidden name=object_id value="{{ $media->id }}">
    <input type=hidden name=resized_temp_h value="{!! $current_h!!}">
    <input type=hidden name=resized_temp_w value="{!! $current_w !!}">
    <div style="padding: 10px;margin:0 auto;">
        <img alt="" src="{{ $url }}" id="crop_image"/>
    </div>
    <div class="container px-3">
        <div class="row">
            <div class="col-sm-3">
                <div class="input-group">
                    <span class="input-group-text">Largeur</span>
                    <input type="text" class="form-control" id="w" name="wimage"/>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="input-group">
                    <span class="input-group-text">Hauteur</span>
                    <input type="text" class="form-control" id="h" name="himage"/>
                </div>
            </div>
            <div class="col-sm-6 text-end">
                <img src="{{ asset('vendor/aboleon/mediaclass/jcrop/loading.svg') }}" alt="" class="d-inline-block d-none" id="mediaclas-loader" style='height:40px'>
                <button type="submit" class="btn btn-secondary" id="mediaclass-crop-btn">Valider le recadrage</button>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Annuler</button>
            </div>
        </div>
    </div>
</form>
