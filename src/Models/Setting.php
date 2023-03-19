<?php

namespace MetaFramework\Models;

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
        return collect(config('settings'))->pluck('elements.*.name')->flatten()->toArray();
    }

    private static function getDefinedSettingFields(): Collection
    {
        return collect(config('settings'))->pluck('elements')->flatten(1);
    }

    public static function add($key, $val): bool
    {
        if (self::has($key)) {
            return Setting::where('name', $key)->update([
                'value' => $val
            ]);
        }

        return self::create(['name' => $key, 'value' => $val]) ? $val : false;
    }

    public static function has($key): bool
    {
        return (boolean)self::getAllSettings()->whereStrict('name', $key)->count();
    }

    public static function get($key): string|bool
    {
        if (!self::has($key)) {
            return false;
        }

        $setting = self::getAllSettings()->where('name', $key)->first();
        return $setting?->value ?? false;
    }

    public static function getAllSettings(): Collection
    {
        return self::all();
    }

    public static function getDefaultValueForField($key): string
    {
        if ($setting = self::getDefinedSettingFields()->where('name', $key)->first()) {
            return $setting['default'] ?? '';
        }
        return '';
    }
}
