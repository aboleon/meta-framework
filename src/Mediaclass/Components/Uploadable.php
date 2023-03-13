<?php

namespace MetaFramework\Mediaclass\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class Uploadable extends Component
{
    public function __construct(
        public object $model,
        public bool   $positions = false,
        public string $group = 'media',
        public string $size = '',
        public string $label = 'Médias',
        public array $settings = []
    )
    {
        $this->group = $this->settings['group'] ?? $this->group;
        $this->label = $this->settings['label'] ?? $this->label;
    }


    public function render(): Renderable
    {
        return view('mediaclass::components.uploadable');
    }

}
