<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class Alert extends Component
{

    public function __construct(
        public string $message,
        public string $type = 'danger'
    )
    {
    }

    public function render(): Renderable
    {
        return view('mfw::components.alert');
    }
}
