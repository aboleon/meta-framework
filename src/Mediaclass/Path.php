<?php

namespace Aboleon\MetaFramework\Mediaclass;

use Illuminate\Support\Str;
use Aboleon\MetaFramework\Mediaclass\Interfaces\MediaclassInterface;
use ReflectionClass;

class Path
{
    public static function mediaFolderName(MediaclassInterface $model): string
    {
        return Str::snake((new ReflectionClass($model))->getShortName()) . '/' . ($model->id ?? 'temp');
    }

    public static function mediaTempFolderName(MediaclassInterface $model): string
    {
        return Str::snake((new ReflectionClass($model))->getShortName()) . '/temp';
    }

    public static function checkMakeDir(string $directory, int $permissions=0755): void
    {
        if (!is_dir($directory)) {
            mkdir($directory, $permissions, true);
        }
    }
}
