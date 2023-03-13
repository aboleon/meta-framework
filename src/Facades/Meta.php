<?php

namespace  MetaFramework\Facades;

use Illuminate\Support\Facades\Facade;

class Meta extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'meta';
    }
}
