<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class Notice extends Component
{
    public function __construct(
        public ?string $message=null,
        public string $type='info'
    ){}

    public function render(): Renderable
    {
        return view('metaframework::components.notice');
    }
}
