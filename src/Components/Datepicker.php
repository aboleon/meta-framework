<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class Datepicker extends Component
{
    /**
     * @property $config
     * ex: dateFormat=d/m/Y
     */

    private array $params;
    public function __construct(
        public string $name,
        public int|float|null $value = null,
        public string $format = 'd/m/Y',
        public ?string $config = null,
        public string|null $label = '',
        public ?string $class = null,
        public bool $required = false,
    )
    {
        $this->class = rtrim('datepicker ' . $this->class.' ');
    }

    public function render(): Renderable
    {
        $this->params = [
            'data-date-format' => $this->format,
        ];

        if ($this->config) {
            $this->params['data-config'] = $this->config;
        }

        return view('mfw::components.datepicker')->with([
            'label' => $this->label,
            'class' => $this->class,
            'required' => $this->required,
            'value' => $this->value,
            'params' => $this->params
        ]);
    }
}
