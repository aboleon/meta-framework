<?php

namespace MetaFramework\Mediaclass\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;
use MetaFramework\Mediaclass\Traits\Accessors;

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

    public function extension(): string
    {
        return match ($this->mime) {
            'image/png' => '.png',
            'image/svg', 'image/svg+xml' => '.svg',
            default => '.jpg',
        };
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
        return Storage::disk('media')->url($this->model->accessKey() . '/' . $this->dimensionPrefix(prefix: $size) . $this->filename . $this->extension());
    }

    public function file(string $size = 'sm'): string
    {
        return Storage::disk('media')->get($this->model->accessKey() . '/' . $this->dimensionPrefix(prefix: $size) . $this->filename . $this->extension());
    }

    public function isCropped(): bool
    {
        return Storage::disk('media')->exists($this->model->accessKey() . '/' . $this->dimensionPrefix(prefix: 'cropped') . $this->filename . $this->extension());

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
