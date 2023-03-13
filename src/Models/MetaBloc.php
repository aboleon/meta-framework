<?php

namespace MetaFramework\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;
use Throwable;

final class MetaBloc
{

    protected static string $path = 'app/Models/Meta/Taxonomy/Bloc';
    protected static string $namespace = 'App\Models\Meta\Taxonomy\Bloc';

    public static function getModels(): array
    {
        $data = [
            MetaBloc::class
        ];

        $blocs = File::files(base_path(self::$path));
        if ($blocs) {
            foreach ($blocs as $file) {
                $data[] = self::$namespace . '\\' . $file->getFilenameWithoutExtension();
            }
        }
        return $data;
    }

    public static function selectableArray(): array
    {
        $blocs = self::getModels();
        $data = [];
        try {
            foreach ($blocs as $bloc) {
                $data[$bloc] = $bloc::getLabel();
            }
        } catch (Throwable) {

        }
        return $data;
    }

    public static function getBlocsForMeta(int $id): Collection
    {
        return Meta::where('type', 'bloc')->where('parent', $id)
            ->select('id', 'title', 'taxonomy', 'position')
            ->orderBy('position')
            ->get();
    }

}
