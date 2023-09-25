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
        return static::values();
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
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

    public static function getValueFromTranslation(string $keyword): bool|string
    {
        return collect(self::translations())->search(function ($item, $key) use ($keyword) {
            return strtolower($item) == strtolower($keyword);
        });
    }

    public static function toSelectArray(): array
    {
        $result = [];
        foreach (self::cases() as $case) {
            $result[$case->value] = $case->value;
        }
        return $result;
    }
}
