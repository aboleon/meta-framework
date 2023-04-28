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
}