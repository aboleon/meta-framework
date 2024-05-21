<?php

namespace App\Enum;

use Aboleon\MetaFramework\Interfaces\BackedEnumInteface;
use Aboleon\MetaFramework\Traits\BackedEnum;

enum UserType: string implements BackedEnumInteface
{

    case ACCOUNT = 'account';
    case SYSTEM = 'system';

    use BackedEnum;

    public static function default(): string
    {
        return self::SYSTEM->value;
    }

}
