<x-backend-layout>
    <x-slot name="header">
        <div class="float-end d-flex align-items-center me-3">

            @if ($model->buttons['status'])
                {!! $data->printStatusAsBadge() !!}
            @endif
                @if ($data->type !='bloc')
                    @if ($model->buttons['index'])
                        <a class="btn btn-sm btn-secondary py-2 mx-2"
                           href="{{ $data->subModel()->urls['index'] ?: route('mfw.meta.list', ['type'=>$data->type]) }}">Liste {{ __('meta.'.$data->type.'.label') }}</a>
                    @endif
                    @if ($model->buttons['create'])
                        <a class="btn btn-sm btn-info py-2"
                           href="{{ route('mfw.meta.create', ['type'=>$data->type]) }}">Créer</a>
                    @endif
                @else

                    <a class="btn btn-danger ms-2" href="#"
                       data-bs-toggle="modal"
                       data-bs-target="#destroy_{{ $data->id }}">
                        Supprimer
                    </a>

                    <x-mfw::modal :route="route('mfw.meta.destroy', $data->id)"
                             question="Supprimer ce bloc ?"
                             :params="['redirect' => route('mfw.meta.show', ['type'=>$data->hasParent->type, 'id'=>$data->hasParent->id])]"
                             reference="destroy_{{ $data->id }}"/>

                    <a class="btn btn-sm btn-secondary py-2 mx-2"
                       href="{{ route('mfw.meta.show', ['type'=>$data->hasParent->type, 'id'=>$data->hasParent->id]) }}"><i style="font-size: 12px" class="opacity-50 fa-solid fa-angles-right"></i> {{ $data->hasParent->title }}
                    </a>
                @endif
            <div id="topbar_submit">
                <button id="topbar_submit" form="wagaia-form" class="btn btn-sm btn-warning py-2 mx-2">Enregistrer</button>
            </div>
        </div>
        <h2 class="font-semibold leading-tight" style="font-size: 24px">
            <x-mfw::meta-url :locale="$current_locale" :meta="$data->type != 'bloc' ? $data : $data->hasParent"/>
        </h2>
    </x-slot>

    @push('css')
        {!! csscrush_tag(public_path('vendor/mfw/css/meta/editable.css')) !!}
    @endpush
    <form method="post" action="{{ $data->id ? route('mfw.meta.update', $data->id) : route('mfw.meta.store') }}" enctype="multipart/form-data" id="wagaia-form">
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
                    <x-mfw::meta-card :meta="$data" />
                @endif
                <x-mfw::meta-blocs :meta="$data"/>
            </div>
            <div class="col-md-8 pe-md-4">
                <x-mfw::meta-model-fillables :meta="$data" :locale="$current_locale"/>
            </div>
        </div>

        <x-mfw::btn-save/>
    </form>

    <div id="mediaclass-crop" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
    @push('js')
        <script src="{{ asset('vendor/mfwjs/published_status.js') }}"></script>
    @endpush
</x-backend-layout>
