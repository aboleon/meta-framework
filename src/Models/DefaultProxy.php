<?php

namespace MetaFramework\Models;

use MetaFramework\Abstract\MetaModel;

final class DefaultProxy extends MetaModel
{
    public static string $signature = 'default_proxy';

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);


        $this->fillables = [
            'meta[content]' => [
                'type' => 'textarea',
                'class' => 'extended',
                'label' => 'Texte'
            ],
        ];


        $this->fillables = [];
        $this->uses['meta_model'] = true;

        $this->defineTranslatables();
    }

}
