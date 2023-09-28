<?php

namespace MetaFramework\Accessors;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use MetaFramework\Models\Vat;

class Prices
{
    public static function fromInteger(int $price): int|float
    {
        return $price/100;
    }

    public static function toInteger(int $price): int
    {
        return $price*100;
    }

    public static function readableFormat(int|float $price, string $currency = '€'): string
    {
        return rtrim(number_format($price, 0, ' ') . ' '.$currency);
    }

    public static function formatPrice(int|float $price, bool $isInCents = false): string
    {
        $cents = $isInCents ? $price : $price * 100; // avoid floating point arithmetic completely (i.e., good)
        $string = str_pad($cents, 3, '0', STR_PAD_LEFT);
        return substr($string, 0, -2) . '.' . substr($string, -2);
    }
}