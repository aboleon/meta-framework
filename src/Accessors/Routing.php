<?php

namespace MetaFramework\Accessors;

class Routing
{

    public static function backend(): string
    {
        return config('mfw.urls.backend', 'mfw');
    }

}