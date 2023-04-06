<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class Radio extends Component
{
    public function __construct(
        public array $values,
        public string $name,
        public int|string|null $affected,
        public string|null $label = '',
        public int|string|null $default = null
    )
    {}

    public function render(): Renderable
    {
        return view('mfw::components.radio');
    }
}
