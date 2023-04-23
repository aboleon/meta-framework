<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class MetaFillableParser extends Component
{
    public function __construct(
        public object $model,
        public string $key,
        public array  $value,
        public string $inputkey,
        public mixed $content,
        public ?string $uuid = null,
        public string $subkey='undefined',
    )
    {
    }

    public function render(): Renderable
    {
        return view('mfw::components.meta-fillable-parser');
    }
}
