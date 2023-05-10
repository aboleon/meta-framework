<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class Input extends Component
{

    public function __construct(
        public string $name,
        public int|string|float|null $value = '',
        public string $type = 'text',
        public array $params = [],
        public string|null $label = '',
        public string $class = '',
        public bool $required = false,
    )
    {
    }

    public function render(): Renderable
    {
        return view('mfw::components.input');
    }
}
