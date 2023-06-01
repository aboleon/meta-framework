<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use MetaFramework\Functions\Helpers;

class Select extends Component
{
    private string $id;
    private string $validation_id;

    public function __construct(
        public array $values,
        public string $name,
        public int|string|null $affected = null,
        public string $label = '',
        public bool $nullable = true,
        public bool $disablename = false,
        public string $defaultselecttext = '',
        public bool $group = false,
        public ?string $class = null,
        public array $params = [],
    )
    {
        $this->defaultselecttext = $this->defaultselecttext ?: '---  '. __('mfw.select_option') .' ---';
        $this->class = rtrim('form-control form-select '  . $this->class);

        $this->id = Helpers::generateInputId($this->name);
        $this->validation_id = Helpers::generateValidationId($this->name);
    }

    public function render(): Renderable
    {
        return view('mfw::components.select')->with([
            'id' => $this->id,
            'validation_id' => $this->validation_id,
        ]);
    }
}
