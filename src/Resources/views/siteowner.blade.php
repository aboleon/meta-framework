<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Identité de l'enteprise
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="row m-3">
                    <div class="col">
                        <form method="post" action="{!! route('panel.siteowner.store') !!}">
                            @csrf
                            <fieldset>
                                <legend>Identité de l'association</legend>

                            <div class="row mb-3">
                                <div class="col-xxl-6">
                                    <x-metaframework::input name="name" label="Nom de l'association" value="{!! old('name') ?: $data?->name !!}"/>
                                </div>
                                <div class="col-xxl-6">
                                    <x-metaframework::input name="manager" label="Responsable" value="{!! old('manager') ?: $data?->manager !!}"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-xxl-6">
                                    <x-metaframework::textarea label="Adresse" name="address" value="{!! old('address') ?: $data?->address !!}"/>
                                </div>
                                <div class="col-xxl-3">
                                    <x-metaframework::input label="Code postal" name="zip" value="{!! old('zip') ?: $data?->zip !!}"/>
                                </div>
                                <div class="col-xxl-3">
                                    <x-metaframework::input label="Ville" name="ville" value="{!! old('ville') ?: $data?->ville !!}"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-xxl-6">
                                    <x-metaframework::input name="vat" label="Numéro de TVA" value="{!! old('vat') ?: $data?->vat !!}"/>
                                </div>
                                <div class="col-xxl-6">
                                    <x-metaframework::input name="siret" label="SIRET" value="{!! old('siret') ?: $data?->siret !!}"/>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-xxl-6">
                                    <x-metaframework::input name="phone" label="Numéro de téléphone" value="{!! old('phone') ?: $data?->phone !!}"/>
                                </div>
                                <div class="col-xxl-6">
                                    <x-metaframework::input type="email" name="email" label="Adresse e-mail" value="{!! old('email') ?: $data?->email !!}"/>
                                </div>
                            </div>

                            </fieldset>

                            <div class="mt-n5 main-save">
                                <x-metaframework::btn-save/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>

