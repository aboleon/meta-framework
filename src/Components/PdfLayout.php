<?php

namespace Aboleon\MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class PdfLayout extends Component
{
    public function render(): Renderable
    {
        return view('aboleon-framework::layouts.pdf');
    }
}
