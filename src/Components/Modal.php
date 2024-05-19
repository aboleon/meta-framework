<?php

namespace Aboleon\MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class Modal extends Component
{
    public function __construct(
        public string $route,
        public ?string $question = null,
        public ?string $title = null,
        public string $reference = '',
        public array $params = [],
        public string $class = '',
    ) {
        $this->question = $this->question ?? __('aboleon-framework.should_i_delete_record');
        $this->reference = $this->reference ?? 'myModal'.$this->reference;
        $this->title = $this->title ?? __('aboleon-framework.deletion');
    }

    public function render(): Renderable
    {
        return view('aboleon-framework::components.modal');
    }
}
