<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class SingleCheckbox extends Component
{
    public function __construct(
        public int | string | null $value,
        public string $label,
        public string $name,
        public int | string | null $affected,
        public string $class =''
    ) {}

    public function isSelected(): bool
    {
        return $this->affected == $this->value;
    }

    public function render(): Renderable
    {
        return view('mfw::components.single-checkbox');
    }
}
