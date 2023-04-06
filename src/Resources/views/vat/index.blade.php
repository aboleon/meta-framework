<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('sellable.vat') }}
        </h2>
        <div class="d-flex align-items-center" id="topbar-actions">

            <a class="btn btn-sm btn-success"
               href="{{ route('mfw.vat.create') }}">
                <i class="fa-solid fa-circle-plus"></i>
                {{ __('mfw.create') }}
            </a>

            <div class="separator"></div>
            <x-mfw::save-btns/>
        </div>
    </x-slot>
    <div class="my-3 text-center">
        <a class="btn btn-sm btn-success" href="{{ route('mfw.vat.create') }}">Créer</a>
    </div>

    <div class="shadow p-3 mb-5 bg-body-tertiary rounded">
        <div class="row m-3">
            <div class="col">

                <x-mfw::response-messages/>

                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('mfw-sellable.vat.rate') }}</th>
                        <th>{{ __('mfw-sellable.vat.default') }}</th>
                        <th width="200">{{ __('mfw.actions.btn') }}</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($data as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ number_format($item->taux, 2, '.') }}</td>
                            <td{!! $item->default ? ' class="bg-success"':'' !!}>{{ $item->default ? __('mfw.yes') : __('mfw.no') }}</td>
                            <td>
                                <div class="dropdown ui-actions">
                                    <button class="btn btn-xs btn-danger dropdown-toggle" type="button"
                                            id="dropdownMenuLink_submenu_actions"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false">{{ __('mfw.actions.btn') }}
                                    </button>

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink_actions">
                                        <li>
                                            <a class="dropdown-item"
                                               href="{{ route('panel.vat.edit', $item->id) }}">
                                                <i class="text-dark fas fa-pen"></i>{{ __('mfw.edit') }}
                                            </a>
                                        </li>
                                        <x-mfw::modal-actions
                                                reference="destroy_{{ $item->id }}"
                                                icon='<i class="text-danger fas fa-trash"></i>' title="{{ __('mfw.delete') }}"/>
                                    </ul>
                                </div>

                                <x-mfw::modal :route="route('panel.vat.destroy', $item->id)"
                                              :question="__('ui.should_i_delete_record')"
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

            </div>
        </div>
    </div>
</x-app-layout>
