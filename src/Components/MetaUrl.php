<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use MetaFramework\Models\Meta;

class MetaUrl extends Component
{
    public function __construct(
        public string $locale,
        public Meta $meta
    )
    {
        //
    }

    public function render(): Renderable
    {
        return view('aboleon-framework::components.meta-url');
    }
}
