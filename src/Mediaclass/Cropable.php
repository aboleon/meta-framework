<?php

namespace Aboleon\MetaFramework\Mediaclass;

use Illuminate\Support\Facades\Route;
use Aboleon\MetaFramework\Mediaclass\Models\Media;
use Aboleon\MetaFramework\Mediaclass\Traits\Accessors;

class Cropable
{
    use Accessors;

    private array $settings = [];
    private int $cropable_width = 0;
    private int $cropable_height = 0;
    public bool $isCropped;

    public function __construct(public Media $media)
    {
        $this->settings();
        $this->checkIfCropped();
    }

    public static function form(Media $media)
    {
        return view('mediaclass::cropper')->with([
            'media' => $media,
            'cropable' => new Cropable($media)
        ]);
    }

    public function link(): string
    {
        if (!$this->settings or $this->isCropped) {
            return '';
        }

        if (!$this->isCropable()) {
            return '';
        }

        return '<a class="crop"
                       data-crop-w="' . $this->cropable_width . '"
                       data-crop-h="' . $this->cropable_height . '"
                       data-bs-toggle="modal"
                       data-bs-target="#mediaclass-crop"
                       href="' . route('mediaclass.cropable', $this->media) . '?w=' . $this->cropable_width . '&h=' . $this->cropable_height . '">
                        <i class="fa-solid fa-crop"></i>
                    </a>';
    }

    public function settings(): self
    {
        $this->settings = $this->media->settings();

        if (array_key_exists('cropable', $this->settings)) {
            $this->cropable_width = (int)current($this->settings['cropable']);
            $this->cropable_height = (int)end($this->settings['cropable']);
        }

        if (Route::currentRouteName() == 'mediaclass.cropable') {
            $this->cropable_width = (int)request('w');
            $this->cropable_height = (int)request('h');
        }

        return $this;
    }

    public function setWidth(int $width): self
    {
        $this->cropable_width = $width;
        return $this;
    }

    public function setHeight(int $height): self
    {
        $this->cropable_height = $height;
        return $this;
    }

    public function setCropableFromComponent(?string $cropable): self
    {
        $this->settings = explode(',', $cropable);
        $this->cropable_width = (int)current($this->settings);
        $this->cropable_height = (int)end($this->settings);

        return $this;
    }


    public function width(): int
    {
        return $this->cropable_width;
    }

    public function height(): int
    {
        return $this->cropable_height;
    }

    public function checkIfCropped(): self
    {
        $this->isCropped = $this->media->isCropped();
        return $this;
    }

    public function isCropable(): bool
    {
        return $this->cropable_width > 0 && $this->cropable_height > 0;
    }

    public function printSizes(): string
    {
        if ($this->isCropped) {
            return $this->cropable_width . ' x ' . $this->cropable_height . $this->printCheckMark();
        }
        return '';
    }

    public function printCheckMark(): string
    {
        if ($this->isCropped) {
            return '<i class="fa-solid fa-circle-check"></i>';
        }
        return '';
    }

}
