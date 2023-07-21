<?php

namespace App\Accessors;

use MetaFramework\Models\Setting;

class Cached
{

    public static function multilang(): bool
    {
        return cache()->rememberForever('multilang', fn() => config('translatable.multilang'));
    }

    public static function settings(string $key): string
    {
        return cache()->rememberForever($key, fn() => Setting::get($key) ?: Setting::getDefaultValueForField($key));
    }

}
