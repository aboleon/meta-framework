@foreach(config('mfw.translatable.locales') as $locale)
    <div class="tab-pane fade {!! $locale == app()->getLocale() ? 'show active': null !!}"
         id="{{ $id }}_{{ $locale }}"
         role="tabpanel"
         aria-labelledby="{{ $id }}_btn_{{ $locale }}">
        <div class="row mb-4">
            <x-mfw::fillable-parser :datakey="$datakey" :fillables="$fillables" :model="$model" :locale="$locale" />
        </div>
    </div>
@endforeach
