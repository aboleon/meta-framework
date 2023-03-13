<?php

namespace MetaFramework\Accessors;

class Routing
{

    public static function backend(): string
    {
        return config('metaframework.urls.backend', 'metaframework');
    }

}