<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use MetaFramework\Functions\Helpers;

class Number extends Component
{

    private array $params;
    private string $id;
    private string $validation_id;
    public function __construct(
        public string $name,
        public int|float|null $value = null,
        public int $min = 0,
        public ?int $max = null,
        public int $step = 1,
        public string|null $label = '',
        public string $class = '',
        public bool $required = false,
    )
    {
        $this->id = Helpers::generateInputId($this->name);
        $this->validation_id = Helpers::generateValidationId($this->name);
    }

    public function render(): Renderable
    {
        $this->params = [
            'min' => $this->min,
            'step' => $this->step
        ];

        if ($this->max) {
            $this->params['max'] = $this->max;
        }

        return view('mfw::components.input')->with([
            'id' => $this->id,
            'validation_id' => $this->validation_id,
            'type' => 'number',
            'label' => $this->label,
            'class' => $this->class,
            'required' => $this->required,
            'value' => $this->value,
            'params' => $this->params
        ]);
    }
}
