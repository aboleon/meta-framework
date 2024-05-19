<?php

namespace Aboleon\MetaFramework\Accessors;

use Aboleon\MetaFramework\Models\Meta;

class Metas {
    public static function fetchSingleByType(string $type)
    {
        return Meta::where('type', $type)->first();
    }
}