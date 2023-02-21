@foreach(config('metaframework.translatable.locales') as $locale)
    <div class="tab-pane fade {!! $locale == app()->getLocale() ? 'show active': null !!}"
         id="tab_content_{{ $locale }}" role="tabpanel"
         aria-labelledby="tab_link_content_{{ $locale }}">
        <div class="row mb-4">
            @foreach($model->fillables as $key=>$value)
                @switch($value['type'])
                    @case('textarea')
                    @case('textarea_extended')
                    <div class="col-12">
                        <x-metaframework::textarea name="{{$key}}[{{$locale}}]"
                                              :className="$value['type'] .' '.($value['class']??'') "
                                              value="{!! $model->translation($key, $locale) !!}"
                                              label="{{$value['label']}}"/>
                    </div>
                    @break
                    @default

                    <div class="{{ $value['class'] ?? 'col-12' }}">
                        <x-metaframework::input name="{{$key}}[{{$locale}}]"
                                           value="{{ $model->translation($key, $locale) }}"
                                           label="{{$value['label']}}"/>
                    </div>
                @endswitch
            @endforeach
        </div>
    </div>
@endforeach
