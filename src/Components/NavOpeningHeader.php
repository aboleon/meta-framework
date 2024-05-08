<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class NavOpeningHeader extends Component
{
    public function __construct(
        public string $class='sh-blue-grey',
        public ?string $icon = null,
        public string $title = ''
    )
    {
        //
    }

    public function render(): Renderable
    {
        return view('aboleon-framework::components.nav-opening-header');
    }
}
