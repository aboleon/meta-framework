<?php

namespace MetaFramework\Accessors;

use MetaFramework\Models\SiteOwner;

class Identity
{

    public static function legal(): SiteOwner
    {
        return cache()->rememberForever('mfw_siteowner', function () {
            return SiteOwner::query()->first();
        });
    }

    public static function get(string $key): ?string
    {
        if ($key == 'address') {
            return implode(', ', (array)cache('mfw_siteowner')?->{$key});
        }

        return cache('mfw_siteowner')?->{$key};
    }

    public static function addressBlock(): string
    {
        return implode("\n", (array)cache('mfw_siteowner')?->address);
    }

    public static function addressLine(int $line = 0): ?string
    {
        $address = (array)cache('mfw_siteowner')?->address;

        return $address[$line] ?? null;
    }

}
