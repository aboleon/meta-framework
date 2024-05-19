<?php

namespace Aboleon\MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use Aboleon\MetaFramework\Interfaces\SeoInterface;

class CardSeo extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     * @object MetaModel $model
     */


    public function __construct(
        public SeoInterface $model)
    {
    }

    public function render(): Renderable
    {
        return view('aboleon-framework::components.card-seo');
    }
}
