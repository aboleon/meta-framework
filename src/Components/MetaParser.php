<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use MetaFramework\Models\Meta;

class MetaParser extends Component
{

    public function __construct(
        public Meta $model,
    )
    {
    }

    public function render(): Renderable
    {
        return view('mfw::components.meta-parser');
    }
}
