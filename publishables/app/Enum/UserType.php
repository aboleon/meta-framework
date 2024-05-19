<?php

namespace App\Enum;

interface UserCustomDataInterface
{
    public function profileData(): array;

    public function mediaSettings(): array;
}


use MetaFramework\Interfaces\BackedEnumInteface;
use MetaFramework\Traits\BackedEnum;

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
