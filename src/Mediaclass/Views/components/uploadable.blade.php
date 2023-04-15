@php
    $positions = (array_key_exists('positions',$settings) && $settings['positions'] === true);
@endphp
<div class="mediaclass-uploadable {{ $size }}"
     data-model="{{ get_class($model) }}"
     data-model-id="{{ $model->id }}"
     data-positions="{{ $positions }}"
     data-group="{{ $group }}"
     data-has-description="{{ $description }}"
>
    <div class="controls d-flex justify-between align-items-center" style="background: #EFEFEF">
        <span class="subcontrol mediaclass-uploader"><i class="fa fa-image"></i> {{ $label }}</span>
        <span class="subcontrol" style="font-size: 14px;font-weight: 700">{{ array_key_exists('sizes', $settings) ? current($settings['sizes']).' x '. end($settings['sizes']): '' }}</span>
    </div>
    <div class="mediaclass-upload-container"></div>
    <div class="uploaded">
        <x-mediaclass::stored :positions="$positions" :medias="$model->media->where('group', $group)" :description="$description"/>
    </div>
</div>
@once
    @if ($model instanceof \MetaFramework\Mediaclass\Interfaces\MediaclassInterface && !isset($model->id))
        <input type="hidden" id="mediaclass_temp_id" name="mediaclass_temp_id" value="{{ Str::random(32) }}">
    @endif
    @include('mediaclass::fileupload_scripts')
    <x-mediaclass::template :model="$model"/>
@endonce
