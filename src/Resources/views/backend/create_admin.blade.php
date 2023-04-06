<x-backend-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Créer un contenu
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-12xl mx-auto sm:px-6 lg:px-8 mb-5">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">

                <x-mfw::validation-banner/>
                <x-mfw::response-messages/>
                    <form method="post" action="{{ route('mfw.meta.create_admin') }}" class="p-4">
                        @csrf
                        <x-mfw::input name="type" label="Type"/>
                        <div class="mt-5 main-save">
                            <x-mfw::btn-save/>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</x-backend-layout>
