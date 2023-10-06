<?php

namespace MetaFramework\Accessors;

use Illuminate\Database\Eloquent\Model;
use MetaFramework\Models\Country;
use Illuminate\Support\Str;

class Countries
{

    /**
     * @return array<mixed>
     */
    public static function orderedCodeNameArray(): array
    {
        return cache()->rememberForever('countries_' . app()->getLocale(), function () {
            return Country::query()->select('name', 'code', 'name' . (Locale::multilang() ? '->' . app()->getLocale() : '') . ' as sortable')->get()
                ->sortBy(fn($item) => Str::slug($item->sortable))
                ->pluck('name', 'code')
                ->toArray();
        });
    }

    public static function getCountryNameByCode(?string $code = null): string
    {
        return self::orderedCodeNameArray()[$code] ?? 'NC';
    }

    /**
     * @param string $addressModel
     * @return array
     */
    public static function selectableByAddressModel(string $addressModel): array
    {
        return $addressModel::distinct('country_code')->get()->mapWithKeys(function ($item) {
            return [$item->country_code ?? 'NC' => self::getCountryNameByCode($item->country_code)];
        })->toArray();
    }

}
