<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class DeleteLink extends Component
{
    public function __construct(
        public int|string $reference,
        public string $route,
        public string $question,
        public string $title,
        public string $modalreference=''
    ) {
        $this->question = $this->question ?? __('ui.should_i_delete_record');
        $this->modalreference = $this->modalreference ?: 'myModal'.$this->reference;
        $this->title = $this->title ?? __('ui.deletion');
    }

    public function render(): Renderable
    {
        return view('metaframework::components.delete-link')->with([
            'modal_id'=> $this->reference
        ]);
    }
}
