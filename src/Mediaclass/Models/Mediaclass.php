<?php

namespace MetaFramework\Mediaclass\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;
use MetaFramework\Mediaclass\Accessors\Path;
use MetaFramework\Mediaclass\Traits\Accessors;
use Symfony\Component\Mime\MimeTypes;

class Mediaclass extends Model
{
    use Accessors;

    protected $table = 'mediaclass';

    protected $guarded = [];
    protected $casts = [
        'description' => 'array'
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function extension(): ?string
    {
       return MimeTypes::getDefault()->getExtensions($this->mime)[0] ?? null;
    }

    public function sizeable(): bool
    {
        return match ($this->mime) {
            'image/png', 'image/jpeg' => true,
            default => false,
        };
    }

    public function url(string $size = 'sm'): string
    {
        return Storage::disk('media')->url(Path::mediaFolderName($this->model) . '/' . $this->dimensionPrefix(prefix: $size) . $this->filename .'.'. $this->extension());
    }

    public function file(string $size = 'sm'): string
    {
        return Storage::disk('media')->get(Path::mediaFolderName($this->model) . '/' . $this->dimensionPrefix(prefix: $size) . $this->filename .'.'. $this->extension());
    }

    public function isCropped(): bool
    {
        return Storage::disk('media')->exists(Path::mediaFolderName($this->model) . '/' . $this->dimensionPrefix(prefix: 'cropped') . $this->filename .'.'. $this->extension());

    }

    public function dimensionPrefix(string $prefix = 'sm'): string
    {
        if (!$this->sizeable()) {
            return '';
        }

        if ($prefix == 'cropped') {
            return 'cropped_';
        }

        if (array_key_exists($prefix, config('mediaclass.dimensions'))) {
            return config('mediaclass.dimensions')[$prefix]['width'] . '_';
        }

        return '';
    }

}
