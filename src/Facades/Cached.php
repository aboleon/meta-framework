<?php

namespace  MetaFramework\Facades;

use Illuminate\Support\Facades\Facade;

class Cached extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'cached';
    }
}
