<x-backend-layout>
    <x-slot name="header">
        <h2>
            Identité de l'enteprise
        </h2>
    </x-slot>

    <div class="shadow p-4 bg-body-tertiary rounded">
        <x-aboleon-framework::validation-banner/>
        <form method="post" action="{!! route('aboleon-framework.siteowner.store') !!}">
            @csrf
            <fieldset>

                <div class="row">
                    <div class="col-sm-6">
                        <h4>Informations légales</h4>
                        <div class="row mb-3">
                            <div class="col-xxl-6">
                                <x-aboleon-inputable::input name="name" label="Dénomination" value="{!! old('name') ?: $data?->name !!}"/>
                            </div>
                            <div class="col-xxl-6">
                                <x-aboleon-inputable::input name="manager" label="Responsable" value="{!! old('manager') ?: $data?->manager !!}"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-xxl-6">
                                <x-aboleon-inputable::input name="vat_number" label="Numéro de TVA" value="{!! old('vat_number') ?: $data?->vat_number !!}"/>
                            </div>
                            <div class="col-xxl-6">
                                <x-aboleon-inputable::input name="reg_number" label="{{ config('aboleon-framework.siteowner.reg_number') }}" value="{!! old('reg_number') ?: $data?->reg_number !!}"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-xxl-6">
                                <x-aboleon-inputable::input name="phone" label="Numéro de téléphone" value="{!! old('phone') ?: $data?->phone !!}"/>
                            </div>
                            <div class="col-xxl-6">
                                <x-aboleon-inputable::input type="email" name="email" label="Adresse e-mail" value="{!! old('email') ?: $data?->email !!}"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h4>Adresse</h4>
                        <div class="row mb-3">
                            <div class="col-12">
                                @if(config('aboleon-framework.siteowner.address_lines') > 1)
                                    @for($i=0;$i<config('aboleon-framework.siteowner.address_lines');++$i)
                                        <div class="mb-3">
                                            <x-aboleon-inputable::input label="L{{ $i+1 }}" name="address[]" value="{!! old('address.'. $i) ?: ($data?->address[$i] ?? '') !!}"/>
                                        </div>
                                    @endfor
                                @else
                                    <x-aboleon-inputable::textarea label="Adresse" height="140" class="mb-3" name="address" value="{!! old('address') ?: (is_array($data?->address) ? current($data->address) : '') !!}"/>
                                @endif
                            </div>
                            <div class="col-sm-6">
                                <x-aboleon-inputable::input label="Code postal" name="zip" value="{!! old('zip') ?: $data?->zip !!}"/>
                            </div>
                            <div class="col-sm-6">
                                <x-aboleon-inputable::input label="Ville" name="locality" value="{!! old('locality') ?: $data?->locality !!}"/>
                            </div>
                        </div>

                    </div>
                </div>


            </fieldset>

            <div class="mt-n5 main-save">
                <x-aboleon-framework::btn-save/>
            </div>
        </form>
    </div>
</x-backend-layout>

