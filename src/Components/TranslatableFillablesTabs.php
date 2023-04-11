<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class TranslatableFillablesTabs extends Component
{
    public function __construct(
        public object $model,
        public string $id = 'tab_translatable',
        public ?string $datakey = null,
        public array $fillables = []
    )
    {
        $this->fillables  = $this->fillables ?: $this->model->fillales;
    }

    public function render(): Renderable
    {
        return view('mfw::components.translatable-fillables-tabs');
    }
}
