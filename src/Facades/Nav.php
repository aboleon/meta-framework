<?php

namespace  MetaFramework\Facades;

use Illuminate\Support\Facades\Facade;

class Nav extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'nav';
    }
}
