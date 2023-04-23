<x-backend-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('meta.'.$type.'.label') }}
            @if ($type)
                &raquo;
            <a class="btn btn-sm btn-nav-blue"
               href="{{ route('mfw.meta.create', ['type'=>$type]) }}">Créer</a>
            @endif
        </h2>
    </x-slot>


    <x-mfw::response-messages/>

    <div class="bg-white shadow-xl sm:rounded-lg px-4 py-2 mb-4" style="margin: 0 -12px">

        <table class="table">
            <tr>
                <th>Titre</th>
                @if(!$type)
                    <th>Type</th>
                    <th>Taxonomie</th>
                @endif
                <th>Publication</th>
                <th>Mise à jour</th>
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
                                @if ($item->url)
                                    <li>
                                        <a target="_blank" href="{{ url($item->url) }}" class="dropdown-item"><i
                                                    class="fas fa-file"></i> Visualiser</a>
                                    </li>
                                @endif
                                <li>
                                    <a class="dropdown-item"
                                       href="{{ route('mfw.meta.edit', $item) }}">
                                        <i class="fas fa-pen"></i> Éditer</a>
                                </li>

                                <x-mfw::modal-actions
                                        reference="destroy_{{ $item->id }}"
                                        icon='<i class="fas fa-trash"></i>' title="Supprimer"/>
                            </ul>
                        </div>
                        <x-mfw::modal :route="route('mfw.meta.destroy', $item->id)"
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
        <x-mfw::pagination :object="$data"/>

    </div>
</x-backend-layout>
