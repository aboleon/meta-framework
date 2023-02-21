<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class MailLayout extends Component
{
    public function render(): Renderable
    {
        return view('metaframework::layouts.mail');
    }
}
