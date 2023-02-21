<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class NavOpeningLink extends Component
{
    public function __construct(
        public string $title,
        public string $icon = ''
    ) {}

    public function render(): Renderable
    {
        return view('metaframework::components.nav-opening-link');
    }
}
