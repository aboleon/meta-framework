<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use MetaFramework\Abstract\MetaModel;
use MetaFramework\Models\Meta;

class MetaBlocs extends Component
{

    public MetaModel $model;

    public function __construct(
        public Meta $meta
    )
    {
        $this->model = $this->meta->subModel();
    }

    public function render(): Renderable
    {
        return view('aboleon-framework::components.meta-blocs');
    }
}
