<?php

declare(strict_types=1);

namespace Aboleon\MetaFramework\Traits;

use Exception;
use Illuminate\Support\Str;

trait AccessKey
{
    public static function generateAccessKey($column = 'access_key', $lenght = 8, $uppercase = false, $attempts = 0): string
    {

        if ($attempts > 10) {
            throw new Exception('Too many attempts to generate a unique ID.');
        }

        $random = Str::random($lenght);
        if ($uppercase) {
            $random = Str::upper($random);
        }

        if (static::where($column, $random)->exists()) {
            return self::generateAccessKey($attempts + 1);
        }

        return $random;
    }

}
