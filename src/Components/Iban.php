<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class Iban extends Component
{

    public function __construct(
        public string $name,
        public ?string $value = null,
        public ?string $label= null,
        public bool $required = false
    )
    {
    }

    public function render(): Renderable
    {
        return view('mfw::components.iban');
    }
}
