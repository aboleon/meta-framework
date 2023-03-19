<?php

namespace  MetaFramework\Facades;

use Illuminate\Support\Facades\Facade;

class NavFacade extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'nav';
    }
}
