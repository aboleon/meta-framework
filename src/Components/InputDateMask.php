<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use MetaFramework\Functions\Helpers;

class InputDateMask extends Component
{


    public function __construct(
        public string                $name,
        public int|string|float|null $value = '',
        public string                $type = 'text',
        public array                 $params = [],
        public string|null           $label = '',
        public string                $class = '',
        public bool                  $required = false,
    )
    {
        $this->class = rtrim('inputdatemask ' . $this->class.' ');
    }

    public function render(): Renderable
    {
        $this->params = array_merge($this->params, ['maxlength' => 10]);

        return view('mfw::components.inputdatemask')->with([
            'label' => $this->label,
            'class' => $this->class,
            'required' => $this->required,
            'value' => $this->value,
            'params' => $this->params
        ]);
    }
}
