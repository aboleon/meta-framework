<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class Select extends Component
{



    public function __construct(
        public array $values,
        public string $name,
        public mixed $affected,
        public string $label = '',
        public bool $nullable = true,
        public bool $disablename = false,
        public string $defaultselecttext = '',
        public bool $group = false,
    )
    {
        $this->defaultselecttext = $this->defaultselecttext ?: '---  '. trans('ui.select_option') .' ---';
    }

    public function render(): Renderable
    {
        return view('metaframework::components.select');
    }
}
