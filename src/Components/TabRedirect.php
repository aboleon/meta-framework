<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;


/**
 * Usage:
 * @depends \src\Traits\Responses
 * 1. blade file, inside form tag : <x-aboleon-framework::tab-redirect />
 * 2. controller : $this->tabRedirect();
 */

class TabRedirect extends Component
{


    public function __construct(
        public string $selector = '.aboleon-framework-tab',
    )
    {}

    public function render(): Renderable
    {
        return view('aboleon-framework::components.tab-redirect');
    }
}
