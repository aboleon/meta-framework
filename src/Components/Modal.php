<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class Modal extends Component
{
    public function __construct(
        public string $route,
        public ?string $question = null,
        public string $title = '',
        public string $reference = '',
        public array $params = []
    ) {
        $this->question = $this->question ?? __('ui.should_i_delete_record');
        $this->reference = $this->reference ?? 'myModal'.$this->reference;
        $this->title = $this->title ?? __('ui.deletion');
    }

    public function render(): Renderable
    {
        return view('metaframework::components.modal');
    }
}
