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
        public bool $disabled = false
    )
    {
        $this->fillables = $this->fillables ?: $this->model->fillables;
    }

    public function render(): Renderable
    {
        return view('mfw::components.translatable-tabs');
    }
}
