<x-backend-layout>
    <x-slot name="header">
        <h2>
            {{ __('meta.'.$type.'.label') }}
        </h2>
        <div class="d-flex align-items-center" id="topbar-actions">
            @if ($type)
                <a class="btn btn-sm btn-success"
                   href="{{ route('aboleon-framework.meta.create', ['type'=>$type]) }}">
                    <i class="fa-solid fa-circle-plus"></i>
                    Créer</a>
            @endif
            <div class="separator"></div>
        </div>
    </x-slot>


    <x-aboleon-framework::response-messages/>

    <div class="shadow p-4 bg-body-tertiary rounded">

        <table class="table table-hover">
            <tr>
                <th>Titre</th>
                @if(!$type)
                    <th>Type</th>
                    <th>Taxonomie</th>
                @endif
                <th>Publication</th>
                <th>Mise à jour</th>
                @role('dev')
                <th>Model
                    <x-aboleon-framework::devmark/>
                </th>
                @endrole
                <th style="width: 100px">Actions</th>
            </tr>
            <tbody>

            @forelse($data as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    @if(!$type)
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->taxonomy }}</td>
                    @endif
                    <td>
                        {!! $item->isActive('span') !!}
                    </td>
                    <td>{{ $item->updated_at?->format('d/m/Y H:i') }}</td>
                    @role('dev')
                    <td>
                        {{ $item->id .' | '. get_class($item->subModel()) }}
                    </td>
                    @endrole
                    <td>
                        <div class="dropdown ui-actions">
                            <button class="btn btn-xs btn-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuLink_submenu_actions_{{$item->id}}"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">Actions
                            </button>

                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink_actions_{{$item->id}}">
                                @if ($item->url)
                                    <li>
                                        <a target="_blank" href="{{ url($item->url) }}" class="dropdown-item"><i
                                                    class="fas fa-file"></i> Visualiser</a>
                                    </li>
                                @endif
                                <li>
                                    <a class="dropdown-item"
                                       href="{{ route('aboleon-framework.meta.edit', $item) }}">
                                        <i class="fas fa-pen"></i> Éditer</a>
                                </li>

                                <x-aboleon-framework::modal-actions
                                        reference="destroy_{{ $item->id }}"
                                        icon='<i class="fas fa-trash"></i>' title="Supprimer"/>
                            </ul>
                        </div>
                        <x-aboleon-framework::modal :route="route('aboleon-framework.meta.destroy', $item->id)"
                                      question="Supprimer {{ $item->title }} ?"
                                      reference="destroy_{{ $item->id }}"/>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        {{ __('errors.no_data_in_db') }}
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <x-aboleon-framework::pagination :object="$data"/>

    </div>
</x-backend-layout>
