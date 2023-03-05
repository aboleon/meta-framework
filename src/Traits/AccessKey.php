<?php

declare(strict_types=1);

namespace MetaFramework\Traits;

use Illuminate\Support\Str;
trait AccessKey
{
    public static function generateAccessKey(): string
    {
        $key = Str::random(8);

        if(static::where('access_key', $key)->exists()) {
            static::generateAccessKey();
        }
        return $key;
    }

}
