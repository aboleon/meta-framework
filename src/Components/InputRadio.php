<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class InputRadio extends Component
{

    public string $id;

    public function __construct(
        public string|int $value,
        public string $name,
        public int|string|null $affected,
        public string $label,
        public int|string|null $default = null
    )
    {
        $this->id = Str::random(16);
    }

    public function render(): Renderable
    {
        return view('mfw::components.inputradio');
    }
}
