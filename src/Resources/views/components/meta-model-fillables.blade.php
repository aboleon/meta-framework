@php
    $model = $meta->subModel();
    $content = $model;

    if ($model->isReliyingOnMeta()) {
        $content = $model->isStoringMetaContentAsJson() ? $meta->content : $meta;
    }
@endphp

@if ($model->fillables)
    @foreach($model->fillables as $key => $collection)
        @php
            $repeatable = ((int)$collection['repeatable'] ??=1) ?: 1;
            $iterable = $repeatable;

            $clonable = $collection['clonable'] ?? false;
            $schema = isset($collection['schema']);
            $key_content = $content->{$key} ?? null;

            if ($clonable) {
                $iterable = is_countable($key_content) ? count($key_content) : 1;
            }

        @endphp

        <div class="fillable bloc-editable{{ $clonable ? ' bloc-clonable' :'' }}" data-repeatable="{{ $repeatable }}">
            @if ($schema)
                <h2>{{ $collection['label'] }}</h2>
            @endif

            @for($i=0;$i<$iterable;++$i)
                @php
                    $random_id = \Illuminate\Support\Str::random(8);
                    $found_content = $content;
                @endphp

                <div class="row{{ $clonable ? ' clonable' : '' }}"{!! $clonable ? ' data-id="'.$random_id.'"' : '' !!}>
                    @if($iterable > 1 or $clonable)
                        <div class="col-md-1 col-sm-2 repeatable pe-0">
                            <div>
                                <span class="i-counter">{{$i+1}}</span>
                                @if ($clonable)
                                    <i class="fa-solid fa-circle-xmark i-remove"></i>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-11 col-sm-10">
                            <div class="row">
                                @endif
                                @php
                                    $grouped = str_starts_with($key, '_group');
                                    $is_meta = str_starts_with($key,'meta[');
                                    $input_key = $is_meta
                                        ? $key
                                        : ($model->getSignature(). (
                                            $grouped
                                            ? ''
                                            : ('['.$key.']' . (
                                                ($repeatable > 1 or $clonable)
                                                ? '['.$random_id.']'
                                                : ''
                                                )
                                            )
                                        )
                                    );
                                    if ($is_meta) {
                                        $key = str_replace(['meta[',']'],'', $key);
                                        $found_content = $content->{$key};
                                    }

                                @endphp
                                @if ($schema)
                                    @if (is_array($key_content))
                                        @php
                                            $found_content = is_array(current($key_content)) ? array_shift($key_content) : $key_content;
                                        @endphp
                                    @endif
                                    @foreach($collection['schema'] as $subkey => $value)

                                        @php
                                            if (!$model->store_in_content) {
                                                $content_value = \MetaFramework\Accessors\Locale::multilang() ? ($found_content[$subkey][$locale] ?? '') : ($found_content[$subkey] ?? '');
                                            } else {
                                                $content_value = $found_content[$key][$subkey] ?? ''; // TODO: no multilang
                                            }
                                        @endphp
                                        <x-metaframework::meta-fillable-parser
                                                :model="$model"
                                                :key="$key"
                                                :subkey="$subkey"
                                                :value="$value"
                                                :content="$content_value"
                                                :inputkey="$input_key.'['.$subkey.']'"/>
                                    @endforeach
                                @else
                                    @php
                                        if ($is_meta) {
                                            $key = str_replace(['meta[',']'],'', $key);
                                        }
                                        $content_value = ($key != '_media') ? $content->translation($key, $locale) : null;
                                    @endphp

                                    <x-metaframework::meta-fillable-parser
                                            :model="$model"
                                            :subkey="$key"
                                            :key="$key"
                                            :content="$content_value"
                                            :value="$collection"
                                            :inputkey="$input_key"/>
                                @endif
                                @if($iterable > 1 or $clonable)
                            </div>
                        </div>
                    @endif
                </div>
            @endfor

            @if ($clonable)
                <span class="cloner btn btn-default btn-sm">Ajouter un élément</span>
            @endif
        </div>
    @endforeach
@endif
@once
    @include('metaframework::lib.tinymce')
    @push('js')
        <link rel="stylesheet" href="{{ asset('vendor/jquery-ui-1.13.0.custom/jquery-ui.min.css') }}">
        <script src="{{ asset('vendor/jquery-ui-1.13.0.custom/jquery-ui.min.js') }}"></script>
        <script>
          const clonableContent = {
            clone: function () {
              $('span.btn.cloner').off().click(function () {
                let cloned = $(this).prev('.clonable').clone(),
                  old_id = cloned.data('id'),
                  new_id = guid(),
                  container = $(this).closest('.bloc-editable');
                clonableContent.attributeUpdater(cloned, old_id, new_id);
                clonableContent.resetEditors(cloned, true);
                cloned.insertBefore($(this));
                clonableContent.resetCounters(container);
                clonableContent.removeTriggers();
                container.find('.i-remove').removeClass('d-none');
              });
            },
            sortable: function () {
              let bcs = $('.bloc-clonable');
              if (bcs.length) {
                bcs.each(function () {
                  let bc = $(this);
                  bc.sortable({
                    stop: function () {
                      bc.find('> div.clonable').each(function (index) {
                        $(this).find('.i-counter').text(index + 1);
                        clonableContent.resetEditors($(this));
                      });
                    },
                  });
                });
              }
            },
            removeTriggers: function () {
              $('.clonable .i-remove').off().click(function () {
                let container = $(this).closest('.bloc-editable');
                $(this).closest('.clonable').remove();
                clonableContent.resetCounters(container);
              });
            },
            resetCounters: function (container) {
              let counters = container.find('.i-counter');
              if (counters.length < 2) {
                container.find('.i-remove').addClass('d-none');
              }
              counters.each(function (index) {
                $(this).text(index + 1);
              });
            },
            attributeUpdater: function (target, old_id, new_id) {

              function replace(variable) {
                return variable.replace(old_id, new_id);
              }

              target.attr('data-id', new_id);

              target.find('textarea, input, select, label').each(function () {
                let name = $(this).attr('name'),
                  id = $(this).attr('id'),
                  label = $(this).attr('for');
                name !== undefined ? $(this).attr('name', replace(name)) : null;
                id === undefined ? $(this).attr('id', $(this).attr('name')) : $(this).attr('id', replace(id));
                label === undefined ? $(this).attr('for', $(this).parent().find('input').attr('id')) : $(this).attr('for', replace(label));
              });
            },
            init: function () {
              this.clone();
              this.removeTriggers();
              this.sortable();
            },
            resetEditors: function (cloned, reset = false) {
              cloned.find('.tox').remove();
              if (reset) {
                cloned.find('input').val('');
              }
              let editors = cloned.find('textarea');
              if (editors.length) {
                editors.removeAttr('style');
                editors.removeAttr('aria-hidden');
                setTimeout(function () {
                  editors.each(function () {
                    let id = '#' + $(this).attr('id');
                    if (reset) {
                      $(this).text('');
                    }
                    if ($(this).hasClass('simplified')) {
                      console.log('setting sip');
                      tinymce.init(simplified_tinymce_settings(id));
                    }
                    if ($(this).hasClass('extended')) {
                      tinymce.init(default_tinymce_settings(id));
                    }
                  });
                }, 100);
              }
            },
          };
          clonableContent.init();
        </script>
    @endpush
@endonce
