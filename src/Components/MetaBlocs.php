<?php

namespace Aboleon\MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use Aboleon\MetaFramework\Abstract\MetaModel;
use Aboleon\MetaFramework\Models\Meta;

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
