<?php

namespace App\Accessors;

use App\Models\AppOwner;

class AppOwnerAccessor
{

    public static function model(): ?AppOwner
    {
        return cache()->rememberForever('aboleon-framework_siteowner', function () {
            return AppOwner::query()->first();
        });
    }

    public static function get(string $key): ?string
    {
        return $key == 'address'
            ? implode(', ', (array)self::model()?->{$key})
            : self::model()?->{$key};

    }

    public static function addressBlock(): string
    {
        return implode("\n", (array)self::model()?->address);
    }

    public static function addressLine(int $line = 0): ?string
    {
        $address = (array)self::model()?->address;

        return $address[$line] ?? null;
    }

}
