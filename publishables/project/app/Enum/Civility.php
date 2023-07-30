<?php

namespace App\Enum;

use MetaFramework\Interfaces\BackedEnumInteface;
use MetaFramework\Traits\BackedEnum;

enum Civility: string implements BackedEnumInteface
{
    case M = 'M';
    case F = 'F';

    use BackedEnum;
    public static function default(): string
    {
        return self::M->value;
    }
}
