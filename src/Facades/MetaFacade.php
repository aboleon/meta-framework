<?php

namespace  Aboleon\MetaFramework\Facades;

use Illuminate\Support\Facades\Facade;

class MetaFacade extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'meta';
    }
}
