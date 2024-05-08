<?php

namespace MetaFramework\Components;

use Illuminate\View\Component;

class Pagination extends Component
{
    public function __construct(public object $object)
    {
    }

    public function render()
    {
        return view('aboleon-framework::components.pagination');
    }
}
