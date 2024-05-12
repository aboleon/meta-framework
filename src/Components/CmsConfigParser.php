<?php

namespace MetaFramework\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use MetaFramework\Interfaces\CmsInterface;

class CmsConfigParser extends Component
{
    public array $config = [];
    public function __construct(
        public CmsInterface $model,
    )
    {
        $this->config = $this->model->configCms();
    }

    public function render(): Renderable
    {
        return view('aboleon-framework::components.cms-config-parser')->with([
            'config' => $this->config,
        ]);
    }
}
