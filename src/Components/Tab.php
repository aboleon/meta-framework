<?php

namespace Aboleon\MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class Tab extends Component
{


    public function __construct(
        public string $tag,
        public string $label,
        public bool $active = false,
    )
    {}

    public function render(): Renderable
    {
        return view('aboleon-framework::components.tab');
    }
}
