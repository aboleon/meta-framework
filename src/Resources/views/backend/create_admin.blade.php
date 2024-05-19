<x-backend-layout>
    <x-slot name="header">
        <h2>
            Créer un contenu
        </h2>
    </x-slot>


    <div class="shadow p-4 bg-body-tertiary rounded">

        <x-aboleon-framework::validation-banner/>
        <x-aboleon-framework::response-messages/>
        <form method="post" action="{{ route('aboleon-framework.meta.create_admin') }}" class="p-4">
            @csrf
            <x-aboleon-inputable::input name="type" label="Type"/>
            <div class="mt-5 main-save">
                <x-aboleon-framework::btn-save/>
            </div>
        </form>
    </div>
</x-backend-layout>
