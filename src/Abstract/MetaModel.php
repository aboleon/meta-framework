<?php

namespace MetaFramework\Abstract;

use MetaFramework\Mediaclass\Interfaces\MediaclassInterface;
use MetaFramework\Models\Meta;
use Illuminate\Database\Eloquent\Builder;

/**
 * Le MetaModel hérite des fonctionnalités du Root Meta model et
 * fourni des fonctionalités (bridge) vers le Meta model dérivé
 */
abstract class MetaModel extends Meta implements MediaclassInterface
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * Récupère la signature du Meta model (TB meta)
     */
    public static function getSignature(): string
    {
        return static::$signature;
    }

    /**
     * Eloquent scope sur la signature du Meta model
     */
    public function scopeSignature($query): Builder
    {
        return $query->whereType(self::getSignature());
    }

    public function getMetaAsTransltable(): array
    {
        return array_map(fn($item) => str_replace(['meta[', ']'], '', $item), array_filter($this->translatable, fn($item) => str_starts_with($item, 'meta[')));
    }

    /**
     * Action complémentaire lors de l'enregistrement du MetaSubModel
     */
    public function store(): static
    {
        return $this;
    }
}
