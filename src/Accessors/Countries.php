<?php

namespace MetaFramework\Accessors;

use MetaFramework\Models\Country;
use Illuminate\Support\Str;

class Countries
{

    /**
     * @return array<mixed>
     */
    public static function orderedCodeNameArray(): array
    {
        return Country::query()->select('name', 'code', 'name' . (Locale::multilang() ? '->fr' : '') . ' as sortable')->get()
            ->sortBy(fn($item) => Str::slug($item->sortable))
            ->pluck('name', 'code')
            ->toArray();
    }

    public static function getCountryNameByCode(?string $code = null): string
    {
        return self::orderedCodeNameArray()[$code] ?? 'NC';
    }

}
