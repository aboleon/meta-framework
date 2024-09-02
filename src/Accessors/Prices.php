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

    public static function toInteger(int|float|string $price): int
    {
        if (is_string($price)) {
            $price = floatval(str_replace(',','.', $price));
        }
        $price = $price * 100;

        return (int)round($price);
    }

    public static function readableFormat(
        int|float $price, string $currency = '€',
        string $decimal_separator = ',',
        string $thousand_separator = ' ',
        bool $showDecimals = true): string
    {
        $formatted_price = number_format($price, 2, $decimal_separator, $thousand_separator);

        list($integer_part, $decimal_part) = explode($decimal_separator, $formatted_price);

        if ($showDecimals) {
            return rtrim($formatted_price . ' ' . $currency);
        }

        return rtrim($integer_part . ' ' . $currency);
    }
}
