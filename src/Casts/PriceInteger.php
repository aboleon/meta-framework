<?php
namespace MetaFramework\Casts;

use DateTime;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;


class PriceInteger implements CastsAttributes
{

    /**
     * @throws \Exception
     */
    public function get($model, $key, $value, $attributes)
    {
        return isset($value) ? $value/100 : null;
    }

    public function set($model, $key, $value, $attributes)
    {
        return isset($value) ? $value*100 : null;
    }
}
