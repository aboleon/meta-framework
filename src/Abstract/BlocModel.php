<?php

namespace MetaFramework\Abstract;


/**
 * Le MetaModel hérite des fonctionnalités du Root Meta model et
 * fourni des fonctionalités (bridge) vers le Meta model dérivé
 */
abstract class BlocModel extends MetaModel
{
    public static string $signature = 'bloc';
    public static string $taxonomy = 'default';
    public static string $label = 'Image + titre + texte';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillables = [
            'media' => [
                'label' => 'Image',
                'positions' => true
            ],
            'meta[title]' => [
                'type' => 'input',
                'label' => 'Titre '
            ],
            'meta[content]' => [
                'type' => 'textarea',
                'class' => 'simplified h-450',
                'label' => 'Texte'
            ],
        ];

        $this->uses['meta_model'] = true;
        $this->disabled_meta = [
            'taxonomy'
        ];

        $this->defineTranslatables();
    }

    public static function getLabel(): string
    {
        return static::$label;
    }

    public static function getTaxonomy(): string
    {
        return static::$taxonomy;
    }

}
