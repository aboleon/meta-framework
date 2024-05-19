<?php

namespace Aboleon\MetaFramework\Functions;

use Illuminate\Support\Str;

class Helpers
{
    public static function generateInputId(string $string): string
    {
        return rtrim(str_replace(['[', ']', '.'], '_', $string), '_');
    }

    public static function generateValidationId(string $string): string
    {
        return rtrim(str_replace(['[', ']'], ['.', ''], $string), '.');
    }

    public static function generateInputName(string $string): string
    {
        if (str_contains($string, '.')) {
            $parts = explode('.', $string);
            return array_shift($parts) . '[' . implode('][', $parts) . ']';
        }
        return $string;
    }
}
