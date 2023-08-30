<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class TranslatableTabs extends Component
{
    public function __construct(
        public object $model,
        public string $id = 'tab_translatable',
        public ?string $datakey = null,
        public array $fillables = [],
        public array $pluck = [],
        public bool $disabled = false
    )
    {
        $this->fillables = $this->fillables ?: $this->model->fillables;
        if ($this->pluck) {
            $this->fillables = array_filter($this->fillables, fn($item) => in_array($item, $this->pluck), ARRAY_FILTER_USE_KEY);

        }
    }

    public function render(): Renderable
    {
        return view('mfw::components.translatable-tabs');
    }
}
