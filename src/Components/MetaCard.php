<?php

namespace MetaFramework\Components;

use MetaFramework\Abstract\MetaModel;
use MetaFramework\Models\Meta;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class MetaCard extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     * @object MetaModel $model
     */


    public MetaModel $model;

    public function __construct(
        public Meta $meta)
    {
        $this->model = $this->meta->subModel();
    }

    public function render(): Renderable
    {
        return view('metaframework::components.meta-card');
    }
}
