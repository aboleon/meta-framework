<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Setting extends Model
{
    public $fillable = ['name', 'value'];

    public static function getValidationRules(): array
    {
        return self::getDefinedSettingFields()->pluck('rules', 'name')
            ->reject(function ($val) {
                return is_null($val);
            })->toArray();
    }

    public static function getConfigElements(): array
    {
        return collect(config('aboleon-framework-settings'))->reduce(function ($carry, $item) {
            return array_merge($carry, $item['elements'] ?? []);
        }, []);
    }

    private static function getDefinedSettingFields(): Collection
    {
        return collect(config('aboleon-framework-settings'))->pluck('elements')->flatten(1);
    }

    public static function get(string $key): ?Setting
    {
        return self::getAllSettings()->filter(fn($item) => $item->name == $key)->first();
    }

    public static function value(string $key): ?string
    {
        return self::getAllSettings()->filter(fn($item) => $item->name == $key)->first()?->value ?? self::defaultSettingValue($key);
    }

    public static function defaultSettingValue(string $key): ?string
    {
        return collect(Setting::getConfigElements())->filter(fn($item) => $item['name'] == $key)->first()['default'] ?? null;
    }

    public static function getAllSettings(): Collection
    {
        return cache()->rememberForever('aboleon-framework-settings', function () {
            return Setting::all();
        });
    }

    public static function getDefaultValueForField($key): string
    {
        if ($setting = self::getDefinedSettingFields()->where('name', $key)->first()) {
            return $setting['default'] ?? '';
        }
        return '';
    }
}
