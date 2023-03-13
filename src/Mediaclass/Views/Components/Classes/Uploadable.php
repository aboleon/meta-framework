<?php

namespace MetaFramework\Mediaclass\Views\Components\Classes;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class Uploadable extends Component
{
    public function __construct(
        public object $model,
        public bool $positions=false,
        public string $group = 'media',
    )
    {

    }

    public function render(): Renderable
    {
        return view('mediaclass::Components.uploadable');
    }

}
