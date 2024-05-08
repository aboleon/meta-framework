<x-backend-layout>
    <x-slot name="header">
        <h2>
            {{ __('aboleon-framework-sellable.vat.label') }}
        </h2>
        <div class="d-flex align-items-center" id="topbar-actions">

            <a class="btn btn-sm btn-success"
               href="{{ route('aboleon-framework.vat.create') }}">
                <i class="fa-solid fa-circle-plus"></i>
                {{ __('aboleon-framework.actions.create') }}
            </a>

            <div class="separator"></div>
            <x-aboleon-framework::save-btns/>
        </div>
    </x-slot>
    <div class="my-3 text-center">
        <a class="btn btn-sm btn-success" href="{{ route('aboleon-framework.vat.create') }}">Créer</a>
    </div>

    <div class="shadow p-3 mb-5 bg-body-tertiary rounded">
        <div class="row m-3">
            <div class="col">

                <x-aboleon-framework::response-messages/>

                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ __('aboleon-framework-sellable.vat.rate') }}</th>
                        <th>{{ __('aboleon-framework-sellable.vat.default') }}</th>
                        <th width="200">{{ __('aboleon-framework.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td>{{ $item->rate }}</td>
                            <td{!! $item->default ? ' class="bg-success"':'' !!}>{{ $item->default ? __('aboleon-framework.yes') : __('aboleon-framework.no') }}</td>
                            <td>
                                <ul class="aboleon-framework-actions">
                                    <x-aboleon-framework::edit-link :route="route('aboleon-framework.vat.edit', $item->id)"/>
                                    <x-aboleon-framework::delete-modal-link reference="{{ $item->id }}"/>
                                </ul>
                                <x-aboleon-framework::modal :route="route('aboleon-framework.vat.destroy', $item->id)"
                                              title="{{__('ui.delete')}}"
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
</x-backend-layout>
