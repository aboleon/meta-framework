<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use MetaFramework\Functions\Helpers;

class Textarea extends Component
{
    private string $id;
    private string $validation_id;

    public function __construct(
        public string       $name,
        public ?string      $value = null,
        public ?string      $label = null,
        public string|array $class = '',
        public array        $params = [],
        public int          $height = 200,
        public bool         $required = false,
        public bool         $readonly = false
    )
    {
        $this->id = Helpers::generateInputId($this->name);
        $this->validation_id = Helpers::generateValidationId($this->name);
        $this->name = Helpers::generateInputName($this->name);
    }

    public function render(): Renderable
    {
        return view('mfw::components.textarea')->with([
            'id' => $this->id,
            'validation_id' => $this->validation_id,
        ]);
    }
}
