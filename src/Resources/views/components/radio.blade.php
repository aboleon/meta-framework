<div class="my-3 p-0">
    @if ($label)
        <label class="form-label d-block">{{ $label }}</label>

    @endif

    @forelse($values as $value => $title)
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" value="{{ $value }}" name="{{ $name }}" id="{{ $name.'_'.$loop->iteration }}" {{ isset($affected) && $affected !== '' ? ($affected == $value ? 'checked' : '') : ($default && $default == $value ? 'checked' : '') }}>
            <label class="form-check-label" for="{{ $name.'_'.$loop->iteration }}">
                {{ str_starts_with($title, 'trans.') ? trans(str_replace('trans.','', $title)) : $title }}
            </label>
        </div>
    @empty
        {{ __('ui.no_data_provided') }}
    @endforelse
</div>
