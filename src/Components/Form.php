<?php

namespace Aboleon\MetaFramework\Components;

use Aboleon\MetaFramework\Models\Forms;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class Form extends Component
{
    public function __construct(
        public ?Forms $form,
        public string $label = '',
        public string $btn = ''
    )
    {
        //
    }

    public function render(): ?Renderable
    {
        return $this->form ? view('aboleon-framework::components.form') : null;
    }
}
