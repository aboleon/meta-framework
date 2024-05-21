<x-backend-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ count($data) . ' ' . trans_choice('ui.role', count($data)) }}
        </h2>
    </x-slot>
    <div class="py-12">

        <div class="shadow p-4 bg-body-tertiary rounded">

            <x-aboleon-framework::response-messages/>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('ui.title') }}</th>
                    <th>Clé</th>
                    <th>Type</th>
                    <th>Utilisateurs</th>
                </tr>
                </thead>
                <tbody>

                @forelse($data as $key=>$item)
                    <tr>
                        <td>{{ $item['id'] }}</td>
                        <th>{{ $data[$key]['label'] }}</th>
                        <td>{{ $key }}</td>
                        <td>{{ $item['profile'] }}</td>
                        <td>
                            <a class="btn btn-secondary btn-sm"
                               href="{{ route('aboleon-framework.users.index', $key) }}">{{ $roles[$item['id']] ?? 0  }}</a>
                        </td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-backend-layout>
