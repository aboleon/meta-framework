<?php

namespace Aboleon\MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class LanguageTabs extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $id = 'tab_translatable'
    )
    {
        //
    }

    public function render(): Renderable
    {
        return view('aboleon-framework::components.language-tabs');
    }
}
