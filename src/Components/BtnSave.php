<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class BtnSave extends Component
{
    public string $label = '';
    public ?string $back = null;

    public function __construct(string $label = '', ?string $back = null)
    {
        $this->label = $label ?: __('mfw.save');
        $this->back = $back;
    }


    public function render(): Renderable
    {
        return view('mfw::components.btn-save');
    }
}
