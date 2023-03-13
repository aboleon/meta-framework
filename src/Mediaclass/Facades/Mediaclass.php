<?php

namespace  MetaFramework\Mediaclass\Facades;

use Illuminate\Support\Facades\Facade;

class Mediaclass extends Facade
{
    protected static $cached = false;

    public static function getFacadeAccessor(): string
    {
        return 'mediaclass';
    }
}
