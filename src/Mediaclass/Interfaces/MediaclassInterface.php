<?php

namespace MetaFramework\Mediaclass\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface MediaclassInterface
{
    public function media(): MorphMany;
    public function model(): object;
    /**
     * Get options related to media management for the model.
     *
     * @return array
     * - maxMediaCount: int=0; Defines the maximum number of media items that can be attached to the model.
     *                  A value of 0 indicates no limit, allowing any number of media items.
     *                  Setting it to a positive integer will limit the media to that count.
     *                  For example, setting it to 1 means the model can only have one media item.
     */
    public function getMediaOptions(): array;
}
