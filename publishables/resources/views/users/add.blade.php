<x-backend-layout>
    <x-slot name="header">
        <h2>
            Comptes
        </h2>
        <div class="d-flex align-items-center" id="topbar-actions">
            @if ($account->id)
                <a class="btn btn-sm btn-secondary mx-2"
                   href="{{ route('panel.users.index', 'super-admin') }}">
                    <i class="fa-solid fa-bars"></i>
                    Index
                </a>
                <a class="btn btn-sm btn-success"
                   href="{{ route('panel.users.create') }}">
                    <i class="fa-solid fa-circle-plus"></i>
                    Créer</a>

                <a class="btn btn-danger ms-2" href="#"
                   data-bs-toggle="modal"
                   data-bs-target="#destroy_{{ $account->id }}">
                    <i class="fa-solid fa-trash"></i>
                    Supprimer
                </a>
            @endif

            <div class="separator"></div>
            <x-aboleon-framework::save-btns/>
        </div>
    </x-slot>

    @if ($account->id)
        <x-aboleon-framework::modal :route="route('panel.users.destroy', $account)"
                                question="Supprimer le compte {{ $account->names() }} ?"
                                reference="destroy_{{ $account->id }}"/>
    @endif

    <x-aboleon-framework::validation-banner/>
    <x-aboleon-framework::response-messages/>

    <div class="shadow p-5 mb-5 bg-body-tertiary rounded">
        <form method="post" action="{{ $route }}" id="wagaia-form">
            @php
            if (str_contains(url()->previous(),'oftype')) {
                session()->put('users_redirect', url()->previous());
            }
            @endphp
            <input type="hidden" name="custom_redirect" value="{{ session('users_redirect') }}">
            @csrf
            @if(isset($method))
                @method($method)
            @endif
            <fieldset>
                <legend>{{ $label }}</legend>
                <div>
                    <div class="row gx-5 mb-4">
                        <div class="col-lg-6">
                            <h4>Identité</h4>
                            <div class="row">
                                @include('users.form.ad_nominem')
                            </div>
                            @include('users.form.roles')
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                @include('users.form.password')
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>

            @include('users.form.profile')

        </form>
    </div>

</x-backend-layout>
