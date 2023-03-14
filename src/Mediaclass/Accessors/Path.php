<?php

namespace MetaFramework\Mediaclass\Accessors;

use Illuminate\Support\Str;
use MetaFramework\Mediaclass\Interfaces\MediaclassInterface;
use ReflectionClass;

class Path
{
    public static function mediaFolderName(MediaclassInterface $model): string
    {
        return Str::snake((new ReflectionClass($model))->getShortName()) . '/'.$model->id;
    }
}