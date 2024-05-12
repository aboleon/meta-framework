<?php

namespace MetaFramework\Traits;

use MetaFramework\Polyglote\Traits\Translation;

trait HasSeo
{
    use Translation;

    public function updateSeoData()
    {

    }

    public function getSeoData()
    {

    }

    public function seoColumns(): array
    {
        return [
            'meta_title' => [
                'label' => 'Meta titre',
            ],
            'meta_description' => [
                'label' => 'Meta description',
                'type' => 'textarea',
            ],
            'url' => [
                'label' => 'URL',
            ],
        ];
    }

}