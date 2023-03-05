<?php

namespace App\View\Components;

use App\Abstract\MetaModel;
use App\Models\Meta;
use App\Models\MetaSubModel;
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
