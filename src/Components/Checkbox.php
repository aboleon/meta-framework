<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Checkbox extends Component
{
    public string $forLabel = '';
    public bool $isSelected = false;

    public function __construct(
        public int | string | null $value,
        public string $name,
        public Collection $affected,
        public string|null $label = '',
        public string $class ='',
    ) {
        $this->affected = $this->affected ?? collect();
        $this->forLabel = str_replace(['[',']'],'', $this->name) . $this->value;
        $this->isSelected = (bool)$this->affected->contains($this->value);
    }

    public function render(): Renderable
    {
        return view('metaframework::components.checkbox');
    }
}
