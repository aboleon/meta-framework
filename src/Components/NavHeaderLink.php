<?php

namespace Aboleon\MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class NavHeaderLink extends Component
{
    public function __construct(
        public string $route,
        public string $class='sh-blue-grey',
        public ?string $icon = null,
        public string $title = ''
    )
    {
        //
    }

    public function render(): Renderable
    {
        return view('aboleon-framework::components.nav-header-link');
    }
}
