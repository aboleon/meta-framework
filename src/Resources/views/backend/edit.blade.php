<backend-layout>
    <x-metaframework::slot name="header">
        <div class="float-end d-flex align-items-center me-3">

            @if ($model->buttons['status'])
                {!! $data->printStatusAsBadge() !!}
            @endif
                @if ($data->type !='bloc')
                    @if ($model->buttons['index'])
                        <a class="btn btn-sm btn-secondary py-2 mx-2"
                           href="{{ $data->subModel()->urls['index'] ?: route(\MetaFramework\Accessors\Routing::backend().'.meta.list', ['type'=>$data->type]) }}">Liste {{ __('meta.'.$data->type.'.label') }}</a>
                    @endif
                    @if ($model->buttons['create'])
                        <a class="btn btn-sm btn-info py-2"
                           href="{{ route(\MetaFramework\Accessors\Routing::backend().'.meta.create', ['type'=>$data->type]) }}">Créer</a>
                    @endif
                @else

                    <a class="btn btn-danger ms-2" href="#"
                       data-bs-toggle="modal"
                       data-bs-target="#destroy_{{ $data->id }}">
                        Supprimer
                    </a>

                    <x-metaframework::modal :route="route(\MetaFramework\Accessors\Routing::backend().'.meta.destroy', $data->id)"
                             question="Supprimer ce bloc ?"
                             :params="['redirect' => route(\MetaFramework\Accessors\Routing::backend().'.meta.show', ['type'=>$data->hasParent->type, 'id'=>$data->hasParent->id])]"
                             reference="destroy_{{ $data->id }}"/>

                    <a class="btn btn-sm btn-secondary py-2 mx-2"
                       href="{{ route(\MetaFramework\Accessors\Routing::backend().'.meta.show', ['type'=>$data->hasParent->type, 'id'=>$data->hasParent->id]) }}"><i style="font-size: 12px" class="opacity-50 fa-solid fa-angles-right"></i> {{ $data->hasParent->title }}
                    </a>
                @endif
            <div id="topbar_submit">
                <button id="topbar_submit" form="wagaia-form" class="btn btn-sm btn-warning py-2 mx-2">Enregistrer</button>
            </div>
        </div>
        <h2 class="font-semibold leading-tight" style="font-size: 24px">
            <x-metaframework::meta-url :locale="$current_locale" :meta="$data->type != 'bloc' ? $data : $data->hasParent"/>
        </h2>
    </x-metaframework::slot>

    @push('css')
        {!! csscrush_tag(public_path('vendor/metaframework/css/meta/editable.css')) !!}
    @endpush
    <form method="post" action="{{ $data->id ? route(\MetaFramework\Accessors\Routing::backend().'.meta.update', $data->id) : route(\MetaFramework\Accessors\Routing::backend().'.meta.store') }}" enctype="multipart/form-data" id="wagaia-form">
        @csrf
        @if ($data->id)
            @if (!$data->trashed())
            @method('put')
            @else
                @method('patch')
            @endif
        @endif
        <input type="hidden" name="meta_type" value="{{ $data->type}}">

        <div class="row editable">
            <div class="col-md-4" id="c-meta">
                @if($data->type != 'bloc')
                    <x-metaframework::meta-card :meta="$data" />
                @endif
                <x-metaframework::meta-blocs :meta="$data"/>
            </div>
            <div class="col-md-8 pe-md-4">
                <x-metaframework::meta-model-fillables :meta="$data" :locale="$current_locale"/>
            </div>
        </div>

        <x-metaframework::btn-save/>
    </form>

    <div id="mediaclass-crop" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
    @push('js')
        <script src="{{ asset('vendor/metaframeworkjs/published_status.js') }}"></script>
    @endpush
</backend-layout>
