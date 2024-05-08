<x-backend-layout>
    <x-slot name="header">
        <h2>
            <x-aboleon-framework::meta-url :locale="$current_locale" :meta="$data->type != 'bloc' ? $data : $data->hasParent"/>
        </h2>
        <div class="d-flex align-items-center" id="topbar-actions">

            @if ($model->buttons['status'])
                {!! $data->printStatusAsBadge() !!}
            @endif
            @if ($data->type !='bloc')
                @if ($model->buttons['index'])
                    <a class="btn btn-sm btn-secondary py-2 mx-2"
                       href="{{ $data->subModel()->urls['index'] ?: route('aboleon-framework.meta.list', ['type'=>$data->type]) }}">Liste {{ __('meta.'.$data->type.'.label') }}</a>
                @endif
                @if ($model->buttons['create'])
                    <a class="btn btn-sm btn-info py-2"
                       href="{{ route('aboleon-framework.meta.create', ['type'=>$data->type]) }}">Créer</a>
                @endif
            @else
                <a class="btn btn-danger ms-2" href="#"
                   data-bs-toggle="modal"
                   data-bs-target="#destroy_{{ $data->id }}">
                    Supprimer
                </a>

                <x-aboleon-framework::modal :route="route('aboleon-framework.meta.destroy', $data->id)"
                              question="Supprimer ce bloc ?"
                              :params="['redirect' => route('aboleon-framework.meta.show', ['type'=>$data->hasParent->type, 'id'=>$data->hasParent->id])]"
                              reference="destroy_{{ $data->id }}"/>

                <a class="btn btn-sm btn-secondary py-2 mx-2"
                   href="{{ route('aboleon-framework.meta.show', ['type'=>$data->hasParent->type, 'id'=>$data->hasParent->id]) }}"><i style="font-size: 12px" class="opacity-50 fa-solid fa-angles-right"></i> {{ $data->hasParent->title }}
                </a>
            @endif
            <div class="separator"></div>
            <button form="aboleon-framework-form" class="btn btn-sm btn-warning py-2 mx-2">Enregistrer</button>
        </div>
    </x-slot>

    @push('css')
        {!! csscrush_tag(public_path('vendor/aboleon/framework/css/meta/editable.css')) !!}
    @endpush
    <div class="shadow p-4 bg-body-tertiary rounded">

                <x-aboleon-framework::validation-banner/>
                <x-aboleon-framework::validation-errors/>
                <x-aboleon-framework::response-messages/>


                <form method="post" action="{{ $data->id ? route('aboleon-framework.meta.update', $data->id) : route('aboleon-framework.meta.store') }}" id="aboleon-framework-form">
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
                                <x-aboleon-framework::meta-card :meta="$data"/>
                            @endif
                            <x-aboleon-framework::meta-blocs :meta="$data"/>
                        </div>
                        <div class="col-md-8 pe-md-4">
                            <x-aboleon-framework::meta-model-fillables :meta="$data" :locale="$current_locale"/>
                        </div>
                    </div>
                </form>

                <x-mediaclass::crop-modal />
    </div>

    @push('js')
        <script src="{{ asset('vendor/aboleon/framework/components/published_status.js') }}"></script>
    @endpush
</x-backend-layout>
