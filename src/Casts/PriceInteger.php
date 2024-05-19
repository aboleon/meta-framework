<?php

namespace Aboleon\MetaFramework\Casts;

use DateTime;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Log;


class PriceInteger implements CastsAttributes
{

    /**
     * @throws \Exception
     */
    public function get($model, $key, $value, $attributes)
    {
        return $value / 100;
    }

    public function set($model, $key, $value, $attributes)
    {
        return $value * 100;
    }
}
