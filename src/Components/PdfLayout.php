<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class PdfLayout extends Component
{
    public function render(): Renderable
    {
        return view('mfw::layouts.pdf');
    }
}
