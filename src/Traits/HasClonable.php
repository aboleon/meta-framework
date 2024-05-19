<?php

namespace Aboleon\MetaFramework\Traits;

trait HasClonable
{
    public function cloneSchema(): array
    {
        return [
            'title' => [
                'label' => 'Titre',
            ],
            'text' => [
                'type' => 'textarea',
                'label' => 'Descriptif',
                'input_class' => 'simplified'
            ]
        ];

    }

    public function cloneLimit(): int
    {
        return 1;
    }


}