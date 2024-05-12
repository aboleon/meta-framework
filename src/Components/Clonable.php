<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as Collection;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use MetaFramework\Interfaces\ClonableInterface;

class Clonable extends Component
{
    public array $schema;
    public string $identifier;

    public function __construct(
        public string $label,
        public ClonableInterface $clonable,
        public EloquentCollection|Collection $items,
        public int $repeatable = 1,
        public ?string $requestkey = null
    )
    {
        $this->schema = $this->clonable->cloneSchema();
        $this->identifier = Str::random(12);

        if ($this->items->isEmpty()) {
            $this->items = collect()->push($this->clonable);
        }
    }

    public function render(): Renderable
    {
        return view('aboleon-framework::components.clonable');
    }
}
