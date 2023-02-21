<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class Translatable extends Component
{
    public function __construct(
        public object $model
    )
    {}

    public function render(): Renderable
    {
        return view('metaframework::components.translatable');
    }
}
