<?php

namespace Aboleon\MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class FillableParser extends Component
{
    public function __construct(
        public object $model,
        public string $locale,
        public ?string $datakey = null,
        public array $fillables = [],
        public bool $disabled = false,
        public array $parsed = []
    )
    {
        if (!$this->parsed) {
            $this->fillables = $this->fillables ?: $this->model->fillales;
        }
    }

    public function render(): Renderable
    {
        return view('aboleon-framework::components.fillables-parser');
    }
}
