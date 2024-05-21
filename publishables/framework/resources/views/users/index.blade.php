<x-backend-layout>
    <x-slot name="header">
        <h2>
            {{ $data->total() . ' ' . trans_choice('aboleon-framework.user', $data->total()) . ' '.__('aboleon-framework.with_role') . ' '. __('aboleon-framework-usertype.'.$role.'.label') }}
        </h2>
        <div class="d-flex align-items-center" id="topbar-actions">
            <a class="btn btn-sm btn-success"
               href="{{ route('aboleon-framework.users.create_type', ['role' => $role]) }}">
                <i class="fa-solid fa-circle-plus"></i>
                Créer</a>
            <div class="separator"></div>
        </div>
    </x-slot>
    <div class="shadow p-4 bg-body-tertiary rounded">

        <x-aboleon-framework::response-messages/>

        <div class="nav nav-tabs">
            <a href="{{route('aboleon-framework.users.index', $role)}}"
               class="nav-link @if(!$archived) active @endif">{{__('aboleon-framework.active')}}</a>
            <a href="{{route('aboleon-framework.users.archived', $role)}}"
               class="nav-link @if($archived) active @endif">{{__('aboleon-framework.archived')}}</a>
        </div>
        <table class="table index">
            <thead>
            <tr>
                <th>{{ __('aboleon-framework-account.names') }}</th>
                <th>e-mail</th>
                <th>{{ __('aboleon-framework.creation') }}</th>
                <th>{{ __('aboleon-framework-account.last_seen') }}</th>
                <th width="200">Actions</th>
            </tr>
            </thead>
            <tbody>

            @forelse($data as $item)
                <tr>
                    <td>{{ ucfirst($item->last_name) .' '.$item->first_name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->created_at?->format('d/m/Y H:i') }}</td>
                    <td>{{ $item->last_login_at?->format('d/m/Y H:i') }}</td>
                    <td>
                        <ul class="aboleon-framework-actions">
                            <x-aboleon-framework::edit-link :route="route('aboleon-framework.users.edit', $item)"/>
                            @if ($item->trashed())
                                <x-aboleon-framework::restore-modal-link reference="{{ $item->id }}"/>
                            @else
                                <x-aboleon-framework::delete-modal-link reference="{{ $item->id }}" title="Archiver"/>
                            @endif
                        </ul>

                        @if ($item->trashed())
                            <x-aboleon-framework::modal :route="route('panel.restore')"
                                                        title="Rétablissement d'un compte"
                                                        :params="['object' => $item::class, 'id' => $item->id, 'success_message' => 'Le compte est rétabli']"
                                                        question="Rétablir s le compte {{ $item->names() }} ?"
                                                        reference="restore_{{ $item->id }}"/>
                        @else
                            <x-aboleon-framework::modal :route="route('aboleon-framework.users.destroy', $item)"
                                                        question="Archiver le compte {{ $item->names() }} ?"
                                                        title="Archiver un compte"
                                                        reference="destroy_{{ $item->id }}"/>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        {{ __('aboleon-framework-errors.no_data_in_db') }}
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <x-aboleon-framework::pagination :object="$data"/>

    </div>
</x-backend-layout>
