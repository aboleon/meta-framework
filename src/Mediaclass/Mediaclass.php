<?php

namespace MetaFramework\Mediaclass;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use MetaFramework\Mediaclass\Interfaces\MediaclassInterface;
use MetaFramework\Mediaclass\Models\Media;

class Mediaclass
{

    /**
     * Selected group for querying Mediaclass database
     */
    public ?string $selected_group = null;

    /**
     * A Mediaclass object
     */
    public MediaclassInterface $object;

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
     * Should the media instance be processed as a single one
     */
    protected bool $single = false;

    public function __construct()
    {
        $this->mediaCollection = null;

    }

    /**
     * Sets the group for the image to be looked up in database.
     *
     * @param string $group The group name for the image.
     */
    private function setGroup(string $group): void
    {
        $this->selected_group = $group;
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
     * Fetches the image instance based on the associated object and group.
     *
     * @return static The current instance of the class for method chaining.
     */
    public function fetch(): static
    {
        $this->mediaCollection = $this->selected_group
            ? $this->object->media->where('group', $this->selected_group)
            : $this->object->media;

        $this->unsetSelectedGroup();

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
            $this->parseMedia($this->mediaCollection);
        } else {
            foreach ($this->mediaCollection as $item) {
                $item->model = $this->object;
                $this->parseMedia($item);
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
    public function parseMedia(Media $instance): static
    {
        $this->media[] = (new Parser($instance));

        return $this;
    }

    public function resetMedia() :self
    {
        $this->media = [];
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
    public function forModel(MediaclassInterface $object, ?string $group = null)
    {
        if ($group) {
            $this->setGroup($group);
        }
        $this->media = [];
        $this->on($object)->fetch()->parse();
        return $this;
    }

    /**
     * Traite les médias sur Model obtenu
     * @return $this
     */
    public function onModel(Media $media, ?string $group = null)
    {
        $this->unsetSelectedGroup();
        if ($group) {
            $this->setGroup($group);
        }
        $this->media = [];
        $this->parse();
        return $this;
    }

    /**
     * Récupère le premier média pour un Model
     */
    public function first(): ?Parser
    {
        return $this->media[0] ?? null;
    }

    /**
     * Fetches and parses the image instance.
     *
     * @return \Illuminate\Database\Eloquent\Collection A database collection
     */
    public function get(): EloquentCollection
    {
        return $this->mediaCollection;
    }

    /**
     * Retriver images for a subgroup
     *
     * @return \Illuminate\Database\Eloquent\Collection  collection
     */
    public function forSubGroup(string $identifier)//: EloquentCollection
    {
        return $this->mediaCollection->filter(fn($item) => $item->subgroup == $identifier);
    }

    public function parsedForSubGroup(string $identifier)//: EloquentCollection
    {
        return $this->forSubGroup($identifier)->map(fn($item) => (new Parser($item)));
    }

    /**
     * Retriver images for a group
     *
     * @return \Illuminate\Database\Eloquent\Collection  collection
     */
    public function forGroup(string $identifier): EloquentCollection
    {
        return $this->mediaCollection->filter(fn($item) => $item->group == $identifier);
    }

    public function parsedForGroup(string $identifier): Collection
    {
        return $this->forGroup($identifier)->map(fn($item) => (new Parser($item)));
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

    private function unsetSelectedGroup(): void
    {
        $this->selected_group = null;
    }
}
