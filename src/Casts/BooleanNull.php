<?php

namespace Aboleon\MetaFramework\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;


class BooleanNull implements CastsAttributes
{
    public function get($model, $key, $value, $attributes): ?int
    {
        return $value ? 1 : null;
    }

    public function set($model, $key, $value, $attributes): ?int
    {
        return $value ? 1 : null;
    }
}
