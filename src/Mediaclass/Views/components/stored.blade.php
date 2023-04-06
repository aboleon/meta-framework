@if ($medias->isNotEmpty())
    @foreach($medias as $media)
        @php
            $is_image = $isImage($media);
            $cropable = new \MetaFramework\Mediaclass\Accessors\Cropable($media);
            $preview = $isImage($media) ? $media->url($cropable->isCropped ? 'cropped': 'sm') : asset('vendor/mfw/mediaclass/images/files/' . $media->extension().'.png');
        @endphp
        <div class="mediaclass unlinkable uploaded-image my-2" data-id="{{ $media->id }}" id="mediaclass-{{$media->id}}">
            <span class="unlink"><i class="bi bi-x-circle-fill"></i></span>
            <div class="row m-0">
                <div class="col-sm-3 impImg p-0 position-relative preview {{ $is_image ? 'image' : 'file' }}" style="background-image: url({{ $preview  }});">
                    <div class="actions">
                        <a target="_blank" href="{{ $media->url() }}" class="zoom">
                            <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                        </a>
                        @if($is_image)
                            {!! $cropable->link() !!}
                        @endif
                    </div>
                    @if($is_image)
                        <div class="sizes">{!! $cropable->printSizes() !!}</div>
                    @endif
                </div>
                <div class="col-sm-9 impFileName">
                    <div class="row infos">
                        <div class="col-sm-12">
                            <p class="name">{{ $media->original_filename }}</p>
                        </div>
                    </div>
                    <div class="row params mt-2">
                        <div class="col-sm-7 description no-multilang {{ !$description ? 'd-none' :'' }}">
                            <b>Description
                                <span class="lang">Français</span></b>
                            @foreach(\MetaFramework\Accessors\Locale::projectLocales() as $locale)
                                <textarea name="mediaclass[{{ $media->id }}][description][{{ $locale }}]" type="text" class="mt-2 form-control description">{!! $media->description[$locale] !!}</textarea>
                            @endforeach
                        </div>
                        <div class="col-sm-5 positions text-center ps-2{{ $positions ? '' : ' d-none' }}">
                            <b>Positions par rapport au contenu</b>
                            <div class="choices pt-2">
                                <i class="bi bi-arrow-left-square-fill active" data-position="left"></i><i class="bi bi-arrow-up-square-fill active" data-position="up"></i><i class="bi bi-arrow-down-square-fill active" data-position="down"></i><i class="bi bi-arrow-right-square-fill active" data-position="right"></i><input type="hidden" name="mediaclass[{{ $media->id }}][position]" value="{{ $media->position }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

<div class="mt-2 mediaclass-alerts" data-msg="Aucun média n'est ajouté">
    @if ($medias->isEmpty())
        {!! wg_info_notice("Aucun média n'est ajouté") !!}
    @endif
</div>
