<?php

namespace Aboleon\MetaFramework\Mediaclass;

use Aboleon\MetaFramework\Mediaclass\Models\Media;

class Parser
{
    public readonly int $id;
    public readonly string $group;
    public readonly string $position;
    public readonly mixed $description;
    public readonly array $urls;
    public readonly string $url;
    public readonly string $mime;

    public function __construct(Media $instance, array $sizes = [])
    {

        $urls = $this->parseUrls($instance, $sizes);

        $this->id = $instance->id;
        $this->mime = $instance->mime;
        $this->group = $instance->group;
        $this->position = $instance->position;
        $this->description = $instance->description[app()->getLocale()];
        $this->urls = $urls;
        $this->url = $urls ? end($urls) : '';
    }

    /**
     * Parses the image instance, generating an array of URLs for different sizes.
     */
    public function parseUrls(Media $instance, array $sizes = []): array
    {
        $dimensions = $sizes ?: Config::getSizes();

        $sizes = array_merge(array_keys($dimensions), ['cropped']);
        $urls = [];
        foreach ($sizes as $size) {
            $file = Path::mediaFolderName($instance->model) . '/' . $instance->dimensionPrefix($size) . $instance->filename . '.' . $instance->extension();
            if (Config::getDisk()->exists($file)) {
                $urls[$size] = Config::getDisk()->url($file);
            }
        }

        return $urls;
    }

}