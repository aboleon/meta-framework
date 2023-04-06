<?php

namespace MetaFramework\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteModalLink extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $reference,
        public ?string $title = null,
    )
    {
        $this->title = $this->title ?: __('mfw.delete');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('mfw::components.delete-modal-link');
    }
}
