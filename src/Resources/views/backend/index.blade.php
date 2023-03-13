<x-backend-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('meta.'.$type.'.label') }} &raquo;
            <a class="btn btn-sm btn-nav-blue"
               href="{{ route(\MetaFramework\Accessors\Routing::backend().'.meta.create', ['type'=>$type]) }}">Créer</a>
        </h2>
    </x-slot>


    <x-metaframework::response-messages/>

    <div class="bg-white shadow-xl sm:rounded-lg px-4 py-2 mb-4" style="margin: 0 -12px">

    <table class="table">
        <tr>
            <th>Titre</th>
            <th>Publication</th>
            <th>Mise à jour</th>
            <th style="width: 100px">Actions</th>
        </tr>
        <tbody>

        @forelse($data as $item)
            <tr>
                <td>{{ $item->title }}</td>
                {!! $item->isActive('td') !!}
                <td>{{ $item->updated_at?->format('d/m/Y H:i') }}</td>
                <td>
                    <div class="dropdown ui-actions">
                        <button class="btn btn-xs btn-secondary dropdown-toggle" type="button"
                                id="dropdownMenuLink_submenu_actions_{{$item->id}}"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">Actions
                        </button>

                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink_actions_{{$item->id}}">
                            <li>
                                <a target="_blank" href="{{ url($item->url) }}" class="dropdown-item"><i
                                        class="fas fa-file"></i> Visualiser</a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                   href="{{ route(\MetaFramework\Accessors\Routing::backend().'.meta.show', ['type'=>$type, 'id'=>$item->id]) }}"><i
                                        class="fas fa-pen"></i> Éditer</a>
                            </li>

                            <x-metaframework::modal-actions
                                reference="destroy_{{ $item->id }}"
                                icon='<i class="fas fa-trash"></i>' title="Supprimer"/>
                        </ul>
                    </div>
                    <x-metaframework::modal :route="route(\MetaFramework\Accessors\Routing::backend().'.meta.destroy', $item->id)"
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
    <x-metaframework::pagination :object="$data"/>

    </div>
</x-backend-layout>
