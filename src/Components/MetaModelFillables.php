<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use MetaFramework\Models\Meta;

class MetaModelFillables extends Component
{
    public function __construct(
        public Meta $meta,
        public string $locale,
    )
    {
        //
    }

    public function render(): Renderable
    {
        return view('metaframework::components.meta-model-fillables');
    }
}
