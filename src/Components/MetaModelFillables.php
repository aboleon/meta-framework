<?php

namespace Aboleon\MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use Aboleon\MetaFramework\Models\Meta;

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
        return view('aboleon-framework::components.meta-model-fillables');
    }
}
