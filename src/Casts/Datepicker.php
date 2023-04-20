<?php
namespace MetaFramework\Casts;

use DateTime;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;


class Datepicker implements CastsAttributes
{

    /**
     * @throws \Exception
     */
    public function get($model, $key, $value, $attributes)
    {
        if ($value) {
            $date = DateTime::createFromFormat('Y-m-d', $value);
            return $date->format('d/m/Y');
        }
        return null;
    }

    public function set($model, $key, $value, $attributes)
    {
        if ($value === '0000-00-00') {
            return null;
        }

        $date = DateTime::createFromFormat('d/m/Y', $value);
        return $date->format('Y-m-d');
    }
}
