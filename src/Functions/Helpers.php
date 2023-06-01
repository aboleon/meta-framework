<?php

namespace MetaFramework\Functions;

class Helpers
{
    public static function generateInputId(string $string): string
    {
        return rtrim(str_replace(['[', ']'], '_', $string), '_');
    }

    public static function generateValidationId(string $string): string
    {
        return str_replace(['[', ']'], ['.', ''], $string);
    }
}