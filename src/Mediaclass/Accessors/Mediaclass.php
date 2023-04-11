<?php

namespace MetaFramework\Mediaclass\Accessors;

use MetaFramework\Mediaclass\Interfaces\MediaclassInterface;
use MetaFramework\Mediaclass\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Mediaclass
{
    /**
     * Default group label in Mediaclass database
     */
    public string $group = 'media';

    /**
     * Selected group for querying Mediaclass database
     */
    public ?string $selected_group = null;

    /**
     * A Mediaclass object
     */
    public MediaclassInterface $object;

    /**
     * User provided params for the IMG tag
     */
    protected array $params = [];

    /**
     * The array of urls returned after parsing
     * the Mediaclass model
     */
    protected array $media = [];

    /**
     * The retrieved Mediaclass model
     */
    protected Media|EloquentCollection|null $mediaCollection;

    /**
     * Default image size (base on conventions set up in
     * config/mediaclass.php: xs, sm, md, xl
     */
    protected string $size = 'sm';

    /**
     * Defaut image url
     */
    protected string $default_img;

    /*
     * Should be the default image URL used ?
     */
    protected bool $with_default = true;

    /**
     * Should the media instance be processed as a single one
     */
    protected bool $single = false;

    public function __construct()
    {
        $this->media = [];
        $this->mediaCollection = null;
        $this->default_img = self::defaultImgUrl();

    }

    /**
     * Returns the default image URL based on the existence of 'imgholder.png'.
     *
     * @return string The default image URL, either 'imgholder.png' or 'imgholder.svg (copied on package installation)'.
     */
    public static function defaultImgUrl(): string
    {
        $default = 'imgholder.png';
        return Storage::disk('media')->exists($default) ?
            Storage::disk('media')->url($default)
            : Storage::disk('media')->url('imgholder.svg');
    }

    /**
     * Disables the return of a default image url
     *
     * @return static The current instance of the class for method chaining.
     */
    public function noDefault(): static
    {
        $this->with_default = false;
        return $this;
    }

    /**
     * Sets the group for the image to be looked up in database.
     *
     * @param string $group The group name for the image.
     * @return static The current instance of the class for method chaining.
     */
    public function group(string $group): static
    {
        $this->selected_group = $group;
        return $this;
    }

    /**
     * Sets the size of the image based on the provided input, according to
     * conventions set up in config/mediaclass.php (xs,sm,md,lg)
     *
     * @param string $size The size of the image. Default is 'sm'.
     * @return static The current instance of the class for method chaining.
     */
    public function size(string $size = 'sm'): static
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Associates the current instance with a MediaclassInterface object.
     *
     * @param MediaclassInterface $object The object implementing MediaclassInterface.
     * @return static The current instance of the class for method chaining.
     */
    public function on(MediaclassInterface $object): static
    {
        $this->object = $object;
        return $this;
    }

    /**
     * Sets a custom parameter for the image instance to be returned in the img tag.
     * ex class => someClass
     * @param string $key The parameter key.
     * @param string $value The parameter value.
     * @return static The current instance of the class for method chaining.
     */
    public function param(string $key, string $value): static
    {
        $this->params[$key] = $value;
        return $this;
    }

    /**
     * Fetches the image instance based on the associated object and group.
     *
     * @return static The current instance of the class for method chaining.
     */
    public function fetch(): static
    {
        $this->mediaCollection = $this->selected_group
            ? $this->object->media->where('group', $this->selected_group)
            : $this->object->media;

        return $this;
    }

    /**
     * Parses the fetched image instance into a predefined array.
     *
     * @return static The current instance of the class for method chaining.
     */
    public function parse(): static
    {
        if (!$this->mediaCollection) {
            return $this;
        }

        if (!is_countable($this->mediaCollection)) {
            $this->parseImage($this->mediaCollection);
        } else {
            foreach ($this->mediaCollection as $item) {
                $this->parseImage($item);
            }
        }
        return $this;
    }

    /**
     * Sets the current instance to handle a single image.
     *
     * @return static The current instance of the class for method chaining.
     */
    public function single(): static
    {
        $this->single = true;
        return $this;
    }


    /**
     * Parses the image instance, generating an array of URLs for different sizes.
     *
     * @param Media $instance The Media instance to be parsed.
     * @return static The current instance of the class for method chaining.
     */
    private function parseImage(Media $instance): static
    {
        $sizes = array_merge(array_keys(config('mediaclass.dimensions')), ['cropped']);
        $urls = [];
        foreach ($sizes as $size) {
            $file = Path::mediaFolderName($this->object) . '/' . $instance->dimensionPrefix($size) . $instance->filename . '.' . $instance->extension();

            if (Storage::disk('media')->exists($file)) {
                $urls[$size] = Storage::disk('media')->url($file);
            }
        }

        $this->media[] = [
            'id' => $instance->id,
            'params' => $this->params,
            'group' => $instance->group,
            'position' => $instance->position,
            'description' => $instance->description[app()->getLocale()],
            'urls' => $urls,
            'url' => $urls ? end($urls) : ''
        ];

        return $this;
    }

    /**
     * ------------------------------
     * ACCESSORS
     * ------------------------------
     */

    /**
     * Récupère les médias pour un Model
     * @param \MetaFramework\Mediaclass\Interfaces\MediaclassInterface $object
     * @return $this
     */
    public function forModel(MediaclassInterface $object)
    {
        $this->on($object)->fetch()->parse();
        return $this;
    }

    /**
     * Fetches and parses the image instance.
     *
     * @return \Illuminate\Database\Eloquent\Collection A database collection
     */
    public function mediaCollection(): EloquentCollection
    {
        return $this->mediaCollection;
    }

    /**
     * Fetches and parses the image instance.
     *
     * @return array A predefined array of urls
     */
    public function toArray(): array
    {
        return $this->media;
    }

    /**
     * ------------------------------
     * PRINTERS
     * ------------------------------
     */

    /**
     * Returns the URL of the image with the specified prefix or the default image URL.
     *
     * @param string $prefix The prefix for the image URL. Default is 'cropped'.
     * @param string|null $default_img A default custom image URL. If not provided, it will use the default image URL.
     * @return string The URL of the image.
     */
    public function url(string $prefix = 'cropped', ?string $default_img = null): string
    {
        $media = current($this->media);

        if (empty($media)) {
            return $default_img ?? ($this->with_default ? $this->defaultImgUrl() : '');
        }

        return current(array_filter($media['urls'], fn($item) => $item == $prefix, ARRAY_FILTER_USE_KEY)) ?: end($media['urls']);
    }

    /**
     * Renders the image HTML tags based on the fetched image instance(s) and parameters.
     *
     * @return string The rendered image HTML tags.
     */
    public function render(): string
    {
        if (!$this->media) {
            if ($this->with_default) {
                $this->media[] = [
                    'url' => $this->default_img
                ];
            }
        }

        if ($this->single) {
            $url = $this->media['urls'][$this->size] ?? ($this->media['url'] ?? false);
            if ($url) {
                $html = '<img src="' . $url . '" ';
                foreach ($this->params as $key => $value) {
                    $html .= $key . '="' . $value . '" ';
                }
                $html .= '/>';

                return $html;
            }
            return '';
        }

        $html = '';
        foreach ($this->media as $media) {

            $html .= '<img src="' . $media['url'] . '" ';
            foreach ($this->params as $key => $value) {
                $html .= $key . '="' . $value . '" ';
            }
            $html .= '/>';
        }

        return $html;
    }

}
