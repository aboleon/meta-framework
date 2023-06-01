<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use MetaFramework\Functions\Helpers;

class Input extends Component
{

    private string $id;
    private string $validation_id;

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
        $this->id = Helpers::generateInputId($this->name);
        $this->validation_id = Helpers::generateValidationId($this->name);
    }

    public function render(): Renderable
    {
        return view('mfw::components.input')->with([
            'id' => $this->id,
            'validation_id' => $this->validation_id,
        ]);
    }
}
