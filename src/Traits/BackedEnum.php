<?php

namespace MetaFramework\Traits;

use Illuminate\Support\Str;

trait BackedEnum
{
    public static function varname(): string
    {
        return Str::snake((new \ReflectionClass(static::class))->getShortName());
    }

    public static function keys(): array
    {
        return collect(self::cases())->map(fn($case) => $case->value)->toArray();
    }

    public static function translated(string $key): string
    {
        return self::translations()[$key] ?? self::translations()[self::default()];
    }

    public static function translations(): array
    {
        return cache()->rememberForever('enum_.' . static::varname(), function () {
            $keys = self::keys();
            return array_combine(
                $keys,
                collect($keys)->map(fn($item) => trans('enum.' . static::varname() . '.' . $item))->toArray()
            );
        });


    }
}
