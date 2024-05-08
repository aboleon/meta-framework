<?php

namespace MetaFramework\Accessors;

class Routing
{

    public static function backend(): string
    {
        return config('aboleon-framework.urls.backend', 'aboleon-framework');
    }

}