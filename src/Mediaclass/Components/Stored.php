<?php

namespace MetaFramework\Mediaclass\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Stored extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public Collection $medias,
        public bool $positions = false,
        public int|bool $description = true
    )
    {
        $this->description = $this->description ? 1 : 0;
    }

    public function render(): Renderable
    {
        return view('mediaclass::components.stored');
    }
}
