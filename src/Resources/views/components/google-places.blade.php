{{-- Pour activer la recherche Google Maps Places - class=gmpasbar --}}
@php
    $error = $errors->any();
@endphp
<div class="clearfix gmapsbar" id="mapsbar_{{ $random_id }}">
    <div class="locationField" data-error="">

        @if ($label)
            <label for="geo_text_address_{{ $random_id }}" class="form-label">{{ $label }}</label>
        @endif
        <input type="text"
               name="{{ $field }}[text_address]"
               value="{{ $error ? old($field.'.text_address') : ($geo->text_address ?? ($geo->locality ?? '')) }}"
               class="g_autocomplete form-control"
               id="geo_text_address_{{ $random_id }}"
               placeholder="{{ $placeholder ?:  trans('metaframework.geo.type_address') }}">
    </div>

    <div class="mb-3 row {{ $field }}_fields">
        <div class="col-sm-4 col-street_number">
            <label for="geo_street_number_{{ $random_id }}" class="form-label">{{ trans('metaframework.geo.street_number') }}</label>
            <input class="field street_number form-control {{ $tagRequired('street_number') }}" name="{{ $field }}[street_number]" style="width: 99%" value="{{ $error ? old($field.'.street_number') : ($geo->street_number ?? '') }}" placeholder="{{ trans('metaframework.geo.street_number') }}" id="geo_street_number_{{ $random_id }}"/>
        </div>
        <div class="col-sm-8 col-route">
            <label for="geo_route_{{ $random_id }}" class="form-label">{{ trans('metaframework.geo.route') }}</label>
            <input class="field route form-control {{ $tagRequired('route') }}" name="{{ $field }}[route]" value="{{ $error ? old($field.'.route') : ($geo->route ?? '') }}" placeholder="{{ trans('metaframework.geo.route') }} *" id="geo_route_{{ $random_id }}" />
        </div>
        <div class="col-sm-4 col-postal_code">
            <label for="geo_postal_code_{{ $random_id }}" class="form-label">{{ trans('metaframework.geo.postal_code') }}</label>
            <input type="text" name="{{ $field }}[postal_code]" value="{{ $error ? old($field.'.postal_code') : ($geo->postal_code ?? '') }}" class="form-control postal_code {{ $tagRequired('postal_code') }}" placeholder="{{ trans('metaframework.geo.postal_code') }} *" id="geo_postal_code_{{ $random_id }}" />
        </div>
        <div class="col-sm-8 col-locality">
            <label for="geo_locality_{{ $random_id }}" class="form-label">{{ trans('metaframework.geo.locality') }}</label>
            <input type="text" name="{{ $field }}[locality]" value="{{ $error ? old($field.'.locality') : ($geo->locality ?? '') }}" class="form-control locality {{ $tagRequired('locality') }}" placeholder="{{ trans('metaframework.geo.locality') }} *" id="geo_locality_{{ $random_id }}" />
        </div>
        <div class="col-sm-4 col-administrative_area_level_2">
            <label for="geo_district_{{ $random_id }}" class="form-label">{{ trans('metaframework.geo.district') }}</label>
            <input class="field administrative_area_level_2 form-control {{ $tagRequired('administrative_area_level_2') }}" name="{{ $field }}[administrative_area_level_2]" value="{{ $error ? old($field.'.administrative_area_level_2') : ($geo->administrative_area_level_2 ?? '') }}" id="geo_district_{{ $random_id }}"/>
        </div>
        <div class="col-sm-8 col-administrative_area_level_1">
            <label for="geo_region_{{ $random_id }}" class="form-label">{{ trans('metaframework.geo.region') }}</label>
            <input class="field administrative_area_level_1 form-control {{ $tagRequired('administrative_area_level_1') }}" name="{{ $field }}[administrative_area_level_1]" value="{{ $error ? old($field.'.administrative_area_level_1') : ($geo->administrative_area_level_1 ?? '') }}" id="geo_region_{{ $random_id }}"/>
        </div>
        <div class="col-sm-8 d-none col-administrative_area_level_1_short">
            <label for="geo_region_{{ $random_id }}" class="form-label">{{ trans('metaframework.geo.region') }}</label>
            <input class="field administrative_area_level_1_short form-control" name="{{ $field }}[administrative_area_level_1_short]" value="{{ $error ? old($field.'.administrative_area_level_1_short') : ($geo->administrative_area_level_1_short ?? '') }}" id="geo_region_{{ $random_id }}"/>
        </div>
        <div class="col-sm-4 col-country_code">
            <label for="geo_country_code_{{ $random_id }}" class="form-label">{{ trans('metaframework.geo.country_code') }}</label>
            <input class="field country_code form-control" name="{{ $field }}[country_code]" value="{{ $error ? old($field.'.country_code') : ($geo->country_code ?? '') }}" placeholder="" id="geo_country_code_{{ $random_id }}"/>
        </div>
        <div class="col-sm-8 col-country">
            <label for="geo_country_{{ $random_id }}" class="form-label">{{ trans('metaframework.geo.country') }}</label>
            <input class="field country form-control {{ $tagRequired('country') }}" name="{{ $field }}[country]" value="{{ $error ? old($field.'.country') : ($geo->country ?? '') }}" placeholder="{{ trans('metaframework.geo.country') }} *" id="geo_country_{{ $random_id }}" />
        </div>
    </div>
    <input type="hidden" class="wa_geo_lat" name="{{ $field }}[lat]" value="{{ $error ? old($field.'.lat') : ($geo->lat ?? '') }}"/>
    <input type="hidden" class="wa_geo_lon" name="{{ $field }}[lon]" value="{{ $error ? old($field.'.lon') : ($geo->lon ?? '') }}"/>
</div>
@if ($params)
    <span id="params_mapsbar_{{ $random_id }}" class="d-none">{!! collect($params)->toJson() !!}</span>
@endif
@once
    @push('js')
        <script src="{{ asset('vendor/metaframework/js/components/google-places-geolocate.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('metaframework.google_places_api_key') }}&libraries=places&callback=initialize"></script>
    @endpush
@endonce
