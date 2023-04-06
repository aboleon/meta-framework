<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class Textarea extends Component
{
    public function __construct(
        public string $label,
        public string $name,
        public string|null $value,
        public string|array $class = '',
        public array $params = [],
        public int $height=200,
        public bool $required = false)
    {
    }

    public function render(): Renderable
    {
        return view('mfw::components.textarea');
    }
}
