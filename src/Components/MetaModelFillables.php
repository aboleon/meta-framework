<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use MetaFramework\Models\Meta;

class MetaModelFillables extends Component
{
    public function __construct(
        public Meta $meta,
        public ?string $locale=null,
    )
    {
        $this->locale ??= app()->getLocale();
    }

    public function render(): Renderable
    {
        return view('mfw::components.meta-model-fillables');
    }
}
