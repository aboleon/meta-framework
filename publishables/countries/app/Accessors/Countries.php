<?php


use Aboleon\MetaFramework\Models\Country;
use Illuminate\Support\Str;

class Countries
{

    /**
     * @return array<mixed>
     */
    public static function orderedCodeNameArray(): array
    {
        return cache()->rememberForever('countries_' . app()->getLocale(), function () {
            return Country::query()->select('name', 'code', 'name' . (\Aboleon\MetaFramework\Accessors\Locale::multilang() ? '->' . app()->getLocale() : '') . ' as sortable')->get()
                ->sortBy(fn($item) => Str::slug($item->sortable))
                ->pluck('name', 'code')
                ->toArray();
        });
    }

    public static function getCountryNameByCode(?string $code = null): string
    {
        return self::orderedCodeNameArray()[$code] ?? 'NC';
    }

}
