<?php

namespace MetaFramework\Accessors;

use Illuminate\Support\Facades\Cache;
use MetaFramework\Models\Vat;

class VatAccesor
{
    public static function fetchVatRate(int $vat_id): int
    {
        return Vat::rate($vat_id);
    }

    public static function vatForPrice(float|int $price, int $vat_id): float|int
    {
        $vat_rate = VatAccesor::fetchVatRate($vat_id);
        return number_format(($price / (100 + $vat_rate)) * $vat_rate, 2);
    }

    public static function netPriceFromVatPrice(float|int $price, int $vat_id): float|int
    {
        return $price - VatAccesor::vatForPrice($price, $vat_id);
    }


    public static function vats(): array
    {
        return Cache::rememberForever('vats', fn() => Vat::query()->pluck('rate', 'id'));

    }

    public static function rate(?int $id): float
    {
        return self::vats()[$id] ?? self::defaultRate()->rate;
    }


    public static function defaultRate(): ?self
    {
        return Cache::rememberForever('default_vat_rate', fn() => Vat::query()->where('default', 1)->first());
    }


    public static function readableArrayList(): array
    {
        return VatAccesor::vats()->sortBy('default')->map(fn($item) => number_format($item / 100, 2))->toArray();
    }
}