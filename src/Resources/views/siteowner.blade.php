<x-backend-layout>
    <x-slot name="header">
        <h2>
            Identité de l'enteprise
        </h2>
    </x-slot>

    <div class="shadow p-4 bg-body-tertiary rounded">
        <form method="post" action="{!! route('mfw.siteowner.store') !!}">
            @csrf
            <fieldset>
                <h4>Informations légales</h4>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="row mb-3">
                            <div class="col-xxl-6">
                                <x-mfw::input name="name" label="Dénomination" value="{!! old('name') ?: $data?->name !!}"/>
                            </div>
                            <div class="col-xxl-6">
                                <x-mfw::input name="manager" label="Responsable" value="{!! old('manager') ?: $data?->manager !!}"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-xxl-6">
                                <x-mfw::input name="vat" label="Numéro de TVA" value="{!! old('vat') ?: $data?->vat !!}"/>
                            </div>
                            <div class="col-xxl-6">
                                <x-mfw::input name="siret" label="SIRET" value="{!! old('siret') ?: $data?->siret !!}"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-xxl-6">
                                <x-mfw::input name="phone" label="Numéro de téléphone" value="{!! old('phone') ?: $data?->phone !!}"/>
                            </div>
                            <div class="col-xxl-6">
                                <x-mfw::input type="email" name="email" label="Adresse e-mail" value="{!! old('email') ?: $data?->email !!}"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row mb-3">
                            <div class="col-12">
                                <x-mfw::textarea label="Adresse" height="140" class="mb-3" name="address" value="{!! old('address') ?: $data?->address !!}"/>
                            </div>
                            <div class="col-sm-6">
                                <x-mfw::input label="Code postal" name="zip" value="{!! old('zip') ?: $data?->zip !!}"/>
                            </div>
                            <div class="col-sm-6">
                                <x-mfw::input label="Ville" name="ville" value="{!! old('ville') ?: $data?->ville !!}"/>
                            </div>
                        </div>

                    </div>
                </div>


            </fieldset>

            <div class="mt-n5 main-save">
                <x-mfw::btn-save/>
            </div>
        </form>
    </div>
</x-backend-layout>

