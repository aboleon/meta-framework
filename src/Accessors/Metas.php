<?php

namespace MetaFramework\Accessors;

use MetaFramework\Models\Meta;

class Metas {
    public static function fetchSingleByType(string $type)
    {
        return Meta::where('type', $type)->first();
    }
}