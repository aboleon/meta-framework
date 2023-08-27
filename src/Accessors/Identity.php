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
        return cache('mfw_siteowner')?->{$key};
    }

}
