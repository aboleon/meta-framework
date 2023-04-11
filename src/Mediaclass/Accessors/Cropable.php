<?php

namespace MetaFramework\Mediaclass\Accessors;


use MetaFramework\Mediaclass\Models\Media;
use MetaFramework\Mediaclass\Traits\Accessors;

class Cropable
{
    use Accessors;

    private array|bool $settings;
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
                       data-crop-w="' . current($this->settings['sizes']) . '"
                       data-crop-h="' . end($this->settings['sizes']) . '"
                       data-bs-toggle="modal"
                       data-bs-target="#mediaclass-crop"
                       href="' . route('mediaclass.cropable', $this->media) . '">
                        <i class="fa-solid fa-crop"></i>
                    </a>';
    }

    public function settings(): self
    {
        $this->settings = $this->media->settings();
        return $this;
    }

    public function width(): int
    {
        return current($this->media->settings()['sizes']);
    }

    public function height(): int
    {
        return end($this->media->settings()['sizes']);
    }

    public function checkIfCropped(): self
    {
        $this->isCropped = $this->media->isCropped();
        return $this;
    }

    public function isCropable(): bool
    {
        return is_array($this->settings) && array_key_exists('cropable', $this->settings) && $this->settings['cropable'] === true;
    }

    public function printSizes(): string
    {
        if ($this->isCropable() && $this->isCropped) {
           return current($this->settings['sizes']) . ' x ' . end($this->settings['sizes']) . $this->printCheckMark();
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
